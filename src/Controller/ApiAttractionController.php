<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Attraction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;

class ApiAttractionController extends  AbstractController
{


/******************Ajouter Attraction*****************************************/
     /**
      * @Route("/addAttraction", name="add_Attraction")
      * @Method("POST")
      */

      public function ajouterAttraction(Request $request)
      {
          $attraction = new Attraction();
          $libelle = $request->query->get("libelle");
          $localisation = $request->query->get("localisation");
          $horraire = $request->query->get("horraire");
          $prix = $request->query->get("prix");
          $image = $request->query->get("image");
          
          $em = $this->getDoctrine()->getManager();
          
 
          $attraction->setLibelle($libelle);
          $attraction->setLocalisation($localisation);
          $attraction->setHorraire($horraire);
          $attraction->setPrix($prix);
          $attraction->setImage($image);
 
          $em->persist($attraction);
          $em->flush();
          $serializer = new Serializer([new ObjectNormalizer()]);
          $formatted = $serializer->normalize($attraction);
          return new JsonResponse($formatted);
 
      }
 
       /******************Supprimer Hotel*****************************************/

     /**
      * @Route("/deleteAttraction", name="delete_Attraction")
      * @Method("DELETE")
      */

     public function deleteAttraction(Request $request) {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $attraction = $em->getRepository(Attraction::class)->find($id);
        if($attraction!=null ) {
            $em->remove($attraction);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("attraction a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id attraction invalide.");


    }

     /******************Modifier Hotel*****************************************/
    /**
     * @Route("/updateAttraction", name="update_Attraction")
     * @Method("PUT")
     */
    public function modifierAttraction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $attraction = $this->getDoctrine()->getManager()
                        ->getRepository(Attraction::class)
                        ->find($request->get("id"));

        $attraction->setLibelle($request->get("libelle"));
        $attraction->setLocalisation($request->get("localisation"));
        $attraction->setHorraire($request->get("horraire"));
        $attraction->setPrix($request->get("prix"));
        $attraction->setImage($request->get("image"));
        

        

        $em->persist($attraction);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($attraction);
        return new JsonResponse("attraction a ete modifiee avec success.");

    }

       /******************affichage Hotel*****************************************/

     /**
      * @Route("/displayAttraction", name="display_Attraction")
      */
      public function allRecAction()
      {
 
          $attraction = $this->getDoctrine()->getManager()->getRepository(Attraction::class)->findAll();
          $normalizer = new ObjectNormalizer();
          $normalizer->setCircularReferenceLimit(2);
            // Add Circular reference handler
          $normalizer->setCircularReferenceHandler(function ($object) {
              return $object->getId();
          });
          $normalizers = array($normalizer);
          $serializer = new Serializer($normalizers);
          $formatted = $serializer->normalize($attraction);
          return new JsonResponse($formatted);
 
      }
     
        /******************Detail Hotel*****************************************/

     /**
      * @Route("/detailAttraction", name="detail_Attraction")
      * @Method("GET")
      */

     //Detail Attraction
     public function detailAttraction(Request $request)
     {
         $id = $request->get("id");

         $em = $this->getDoctrine()->getManager();
         $attraction = $this->getDoctrine()->getManager()->getRepository(Attraction::class)->find($id);
         $encoder = new JsonEncoder();
         $normalizer = new ObjectNormalizer();
         $normalizer->setCircularReferenceHandler(function ($libelle) {
             return $libelle->getLibelle();
         });
         $serializer = new Serializer([$normalizer], [$encoder]);
         $formatted = $serializer->normalize($attraction);
         return new JsonResponse($formatted);
     }
    }