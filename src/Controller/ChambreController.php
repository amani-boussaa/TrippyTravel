<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Hotelreservation;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\HttpFoundation\JsonResponse;

class ChambreController extends AbstractController
{


     /******************Ajouter Chambre*****************************************/
     /**
      * @Route("/addChambre", name="add_Chambre")
      * @Method("POST")
      */

      public function ajouterChambrem(Request $request)
      {
          $chambre = new Chambre();
          $typechambre = $request->query->get("typechambre");
          $prix = $request->query->get("prix");
          $description_chambre = $request->query->get("description_chambre");
          $hotel = $request->query->get("hotel");

          
          $em = $this->getDoctrine()->getManager();
          
 
          $chambre->setTypechambre($typechambre);
          $chambre->setPrix($prix);
          $chambre->setDescriptionChambre($description_chambre);
          $chambre->setHotel($hotel);
         
          $em->persist($chambre);
          $em->flush();
          $serializer = new Serializer([new ObjectNormalizer()]);
          $formatted = $serializer->normalize($chambre);
          return new JsonResponse($formatted);
 
      }
 
       /******************Supprimer Chambre*****************************************/

     /**
      * @Route("/deleteChambre", name="delete_Chambre")
      * @Method("DELETE")
      */

     public function deleteChambre(Request $request) {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $chambre = $em->getRepository(Chambre::class)->find($id);
        if($chambre!=null ) {
            $em->remove($chambre);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Chambre a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id Chambre invalide.");


    }

     /******************Modifier Chambre*****************************************/
    /**
     * @Route("/updateChambre", name="update_Chambre")
     * @Method("PUT")
     */
    public function modifierChambre(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $chambre = $this->getDoctrine()->getManager()
                        ->getRepository(Chambre::class)
                        ->find($request->get("id"));

        $chambre->setTypechambre($request->get("typechambre"));
        $chambre->setPrix($request->get("prix"));
        $chambre->setDescriptionChambre($request->get("description_chambre"));
        $chambre->setHotel($request->get("hotel"));
        
        
        

        $em->persist($chambre);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($chambre);
        return new JsonResponse("Chambre a ete modifiee avec success.");

    }

       /******************affichage Chambre*****************************************/

     /**
      * @Route("/displayChambre", name="display_Chambre")
      */
      public function allRecAction()
      {
 
          $chambre = $this->getDoctrine()->getManager()->getRepository(Chambre::class)->findAll();
          $normalizer = new ObjectNormalizer();
          $normalizer->setCircularReferenceLimit(2);
  // Add Circular reference handler
          $normalizer->setCircularReferenceHandler(function ($object) {
              return $object->getId();
          });
          $normalizers = array($normalizer);
          $serializer = new Serializer($normalizers);
          $formatted = $serializer->normalize($chambre);
          return new JsonResponse($formatted);
 
      }
     
        /******************Detail Chambre*****************************************/

     /**
      * @Route("/detailChambre", name="detail_Chambre")
      * @Method("GET")
      */

     //Detail Chambre
     public function detailChambre(Request $request)
     {
         $id = $request->get("id");

         $em = $this->getDoctrine()->getManager();
         $chambre = $this->getDoctrine()->getManager()->getRepository(Chambre::class)->find($id);
         $encoder = new JsonEncoder();
         $normalizer = new ObjectNormalizer();
         $normalizer->setCircularReferenceHandler(function ($typechambre) {
             return $object->getDescription();
         });
         $serializer = new Serializer([$normalizer], [$encoder]);
         $formatted = $serializer->normalize($chambre);
         return new JsonResponse($formatted);
     }



    /**
     * @Route("/hotel_single", name="hotel_single")
     */
    public function chambre_single(chambreRepository $chambreRepository): Response
    {
        return $this->render('hotel/hotel_single.html.twig', [
            
            'chambres' => $chambreRepository->findAll(),
            'controller_name' => 'chambreController',
        ]);
    }

    /**
     * @Route("/chambrefront/{id}", name="chambrefront_single" , methods={"GET","POST"})
     */
    public function chambre_one(EntityManagerInterface $entityManage,Request $request,Chambre $chambre): Response
    {
        $hoteleservation = new Hotelreservation();
        $form = $this->createFormBuilder(null)
            ->add('Reserver', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hoteleservation->setPrix($chambre->getPrix());
            $chambre->addHotelreservation($hoteleservation);
            $entityManage->flush();

        }
        return $this->render('chambre/chambre_desc.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    
    }

/**
     * @Route("/listp", name="chambre_listp", methods={"GET"})
     */
    public function listp(ChambreRepository $chambreRepository)
    {



        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
       $chambre= $chambreRepository->findAll();
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('chambre/listp.html.twig', [
            'chambres' => $chambre,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    
       
    }



    /**
     * @Route("/admin-dashboard/chambre/", name="chambre_index", methods={"GET"})
     */
    public function index(ChambreRepository $chambreRepository): Response
    {
        return $this->render('chambre/index.html.twig', [
            'chambres' => $chambreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin-dashboard/chambre/new", name="chambre_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chambre = new Chambre();
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chambre);
            $entityManager->flush();

            return $this->redirectToRoute('chambre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chambre/new.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin-dashboard/chambre/{id}", name="chambre_show", methods={"GET"})
     */
    public function show(Chambre $chambre): Response
    {
        return $this->render('chambre/show.html.twig', [
            'chambre' => $chambre,
        ]);
    }

    /**
     * @Route("/admin-dashboard/chambre/{id}/edit", name="chambre_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Chambre $chambre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('chambre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chambre/edit.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin-dashboard/chambre/{id}", name="chambre_delete", methods={"POST"})
     */
    public function delete(Request $request, Chambre $chambre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chambre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($chambre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('chambre_index', [], Response::HTTP_SEE_OTHER);
    }
}
