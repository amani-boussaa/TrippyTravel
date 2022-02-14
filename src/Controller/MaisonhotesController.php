<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaisonhotesController extends AbstractController
{
    /**
     * @Route("/maisonhotes", name="maisonhotes")
     */
    public function index(): Response
    {
        return $this->render('maisonhotes/index.html.twig', [
            'controller_name' => 'MaisonhotesController',
        ]);
    }
    /**
     * @Route("/admin-dashboard/maisonhotes", name="admin-dashboard/maisonhotes")
     */
    public function admin_index(): Response
    {
        return $this->render('maisonhotes/admin_index.html.twig', [
            'controller_name' => 'MaisonhotesController',
        ]);
    }
}
