<?php

namespace App\Controller;

use App\Repository\MaisonshotesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Maisonshotes;
/**new ads**/
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Json;

class ApiMaisonshotesController extends AbstractController
{
    /**
     * @Route("/api/Maisonshotes", name="api_maisonshotes")
     */
    public function index(MaisonshotesRepository $maisonshotesRepository,SerializerInterface $serializer): Response
    {
        $maisonshotes = $maisonshotesRepository->findAll();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($maisonshotes);
        return new JsonResponse($formatted);
    }


    /**
     * @Route("/api/Maisonshotes/add", name="api_maisonshotes_add")
     */
    public function ajouterMaisonshotesAction(Request $request,SerializerInterface $serializer)
    {
        $maisonshote = new Maisonshotes();
        $em = $this->getDoctrine()->getManager();
        $libelle = $request->query->get("libelle");
        $capacite = $request->query->get("capacite");
        $localisation = $request->query->get("localisation");
        $proprietaire = $request->query->get("proprietaire");
        $prix = $request->query->get("prix");
        $nbrChambres = $request->query->get("nbrChambres");

        $type_maison =$request->query->get("type_maison");


        $maisonshote->setLibelle($libelle);
        $maisonshote->setCapacite($capacite);
        $maisonshote->setLocalisation($localisation);
        $maisonshote->setProprietaire($proprietaire);
        $maisonshote->setPrix($prix);
        $maisonshote->setNbrChambres($nbrChambres);




        $em->persist($maisonshote);
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($maisonshote);
        return new JsonResponse($formatted);
    }
   
    /**
     * @Route("/deleteMaisonshotesapi", name="delete_Maisonshotesapi")
     * @Method("DELETE")
     */

    public function deleteMaisonsAction(Request $request) {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $maisonshote = $em->getRepository(Maisonshotes::class)->find($id);
        if($maisonshote!=null ) {
            $em->remove($maisonshote);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Maison a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id Maison invalide.");


    }
    /**
     * @Route("/updateMaisonapi")
     * @Method("PUT")
     */
    public function modifierMaisonsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $maisonshote = $this->getDoctrine()->getManager()
            ->getRepository(Maisonshotes::class)
            ->find($request->get("id"));

        $maisonshote->setLibelle($request->get("libelle"));
        $maisonshote->setCapacite($request->get("capacite"));
        $maisonshote->setLocalisation($request->get("localisation"));

        $em->persist($maisonshote);
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($maisonshote);
        return new JsonResponse("Maison a ete modifiee avec success.");

    }

}
