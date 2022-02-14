<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/admin-dashboard/blog", name="admin-dashboard/blog")
     */
    public function admin_index(): Response
    {
        $articles=["article 1", "article 2"];
        return $this->render('blog/admin_index.html.twig', [
           'articles'=> $articles
        ]);
    }


}
