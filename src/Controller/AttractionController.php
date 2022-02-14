<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttractionController extends AbstractController
{
    /**
     * @Route("/attraction", name="attraction")
     */
    public function index(): Response
    {
        return $this->render('attraction/index.html.twig', [
            'controller_name' => 'AttractionController',
        ]);
    }
    /**
     * @Route("/admin-dashboard/attraction", name="admin-dashboard/attraction")
     */
    public function admin_index(): Response
    {
        return $this->render('attraction/admin_index.html.twig', [
            'controller_name' => 'ExcursionController',
        ]);
    }
}
