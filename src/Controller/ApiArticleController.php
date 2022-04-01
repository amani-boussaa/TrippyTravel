<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Article;
/**new ads**/
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Json;

class ApiArticleController extends AbstractController
{
    /**
     * @Route("/api/article", name="api_article")
     */
    // public function index(ArticleRepository $articleRepository,SerializerInterface $serializer): Response
    public function index()
    {
        $array1=[];
        $articles = $this->getDoctrine()->getManager()->getRepository(Article::class)->findAll();
        foreach ($articles as $key => $value) {
            if ($value->getImages()[0]) {
                $array["image"] = "http://127.0.0.1:8000/uploads/".$value->getImages()[0]->getName();
            } else {
                $array["image"] = "http://localhost:8000/front-office/images/bg_4.jpg";
            }
            $array["id"] = $value->getId();
            $array["title"] = $value->getTitle();
            $array["content"] = $value->getContent();
            $array["id_category"] = 0;
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
        // $articles = $articleRepository->findAll();
        // $json = $serializer->serialize($articles,'json',['groups'=>'article']);
        // return new Response($json);
    }

    /******************Detail Article*****************************************/

    /**
     * @Route("/detailArticleapi", name="detail_article")
     * @Method("GET")
     */

    //Detail Excursion
    public function detailArticleAction(Request $request)
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getContent();
        });
        $serializer = new Serializer([$normalizer], [$encoder]);
        $formatted = $serializer->normalize($article);
        return new JsonResponse($formatted);
    }

    /******************Ajouter Excursion*****************************************/
    /**
     * @Route("/addArticleapi", name="add_article")
     * @Method("POST")
     */

    public function ajouterArticleAction(Request $request,SerializerInterface $serializer)
    {
        $article = new Article();
        $em = $this->getDoctrine()->getManager();
        $content = $request->query->get("content");
        $objet = $request->query->get("title");
        $id_category = $request->query->get("id_category");
        $cat = $em->getRepository(Category::class)->find($id_category);
        $article->setTitle($objet);
        $article->setContent($content);
        $article->setIdCategory($cat);
        $em->persist($article);
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($article);
        return new JsonResponse($formatted);
    }

    /******************Supprimer Excursion*****************************************/

    /**
     * @Route("/deleteArticleapi", name="delete_articleapi")
     * @Method("DELETE")
     */

    public function deleteArticleAction(Request $request) {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        if($article!=null ) {
            $em->remove($article);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("L article a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id article invalide.");


    }

    /******************Modifier Excursion*****************************************/
    /**
     * @Route("/updateArticleapi", name="update_articleapi")
     * @Method("PUT")
     */
    public function modifierArticleAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getManager()
            ->getRepository(Article::class)
            ->find($request->get("id"));

        $article->setContent($request->get("content"));
        $article->setTitle($request->get("title"));

        $em->persist($article);
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($article);
        return new JsonResponse("L article a ete modifie avec success.");

    }
}