<?php

namespace App\Controller;

use App\Entity\Excursioncategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ExcursionRepository;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Excursion;
/**new ads**/
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Json;

class ApiExcursionController extends AbstractController
{
    /**
     * @Route("/allexcursionapi", name="api_excursion")
     */
    public function index()
    {
        $array1=[];
        $excursions = $this->getDoctrine()->getManager()->getRepository(Excursion::class)->findAll();
        foreach ($excursions as $key => $value) {
            if ($value->getExcursionimages()[0]) {
                $array["image"] = "http://127.0.0.1:8000/uploads/images/excursion/".$value->getExcursionimages()[0]->getImageName();
            } else {
                $array["image"] = "http://localhost:8000/front-office/images/bg_4.jpg";
            }
          
            $array["id"] = $value->getId();
            $array["libelle"] = $value->getLibelle();
            $array["description"] = $value->getDescription();
            $array["programme"] = $value->getProgramme();
            $array["ville"] = $value->getVille();
            $array["prix"] = $value->getPrix();
            $array["duration"] = $value->getDuration();
            $array["localisation"] = $value->getLocalisation();
            $array["comments"] = $value->getExcursioncomments();
            $array["excursioncategorie_id"] = 0;
            $array1[]=$array;
        }
    
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($array1);
        return new JsonResponse($formatted);
    }
//    /**
//     * @Route("/api/excursion/new", name="api_excursion_new")
//     */
//    public function new(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManager): Response
//    {
//        try {
//            $content = $request->getContent();
//            $data = $serializer->deserialize($content,Excursion::class,'json');
//            $entityManager->persist($data);
//            $entityManager->flush();
//            return new Response("Excursion created successfully");
//        }catch (\Exception $exception){
//            return new Response($exception->getMessage());
//        }
//    }
    /******************Detail Excursion*****************************************/

    /**
     * @Route("/detailExcursionapi", name="detail_excursion")
     * @Method("GET")
     */

    //Detail Excursion
    public function detailExcursionAction(Request $request)
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $excursion = $em->getRepository(Excursion::class)->find($id);
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getDescription();
        });
        $serializer = new Serializer([$normalizer], [$encoder]);
        $formatted = $serializer->normalize($excursion);
        return new JsonResponse($formatted);
    }

    /******************Ajouter Excursion*****************************************/
    /**
     * @Route("/addExcursionapi", name="add_excursion")
     * @Method("POST")
     */

    public function ajouterExcursionAction(Request $request,SerializerInterface $serializer)
    {
        $excursion = new Excursion();
        $em = $this->getDoctrine()->getManager();
        $description = $request->query->get("description");
        $programme = $request->query->get("programme");
        $objet = $request->query->get("libelle");
        $ville = $request->query->get("ville");
        $prix = $request->query->get("prix");
        $duration = $request->query->get("duration");
        $excursioncategorie_id = $request->query->get("excursioncategorie_id");
        $cat = $em->getRepository(Excursioncategorie::class)->find($excursioncategorie_id);
        $excursion->setLibelle($objet);
        $excursion->setDescription($description);
        $excursion->setProgramme($programme);
        $excursion->setVille($ville);
        $excursion->setPrix($prix);
        $excursion->setDuration($duration);
        $excursion->setExcursioncategorie($cat);
        $em->persist($excursion);
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($excursion);
        return new JsonResponse($formatted);
    }

    /******************Supprimer Excursion*****************************************/

    /**
     * @Route("/deleteExcursionapi", name="delete_excursiontionapi")
     * @Method("DELETE")
     */

    public function deleteExcursionAction(Request $request) {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $excursion = $em->getRepository(Excursion::class)->find($id);
        if($excursion!=null ) {
            $em->remove($excursion);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Excursion a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id excursion invalide.");


    }

    /******************Modifier Excursion*****************************************/
    /**
     * @Route("/updateExcursionapi", name="update_excursionapi")
     * @Method("PUT")
     */
    public function modifierExcursionAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $excursion = $this->getDoctrine()->getManager()
            ->getRepository(Excursion::class)
            ->find($request->get("id"));

        $excursion->setDescription($request->get("description"));
        $excursion->setLibelle($request->get("libelle"));

        $em->persist($excursion);
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($excursion);
        return new JsonResponse("Excursion a ete modifiee avec success.");

    }
}