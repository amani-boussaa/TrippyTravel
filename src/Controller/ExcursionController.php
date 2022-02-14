<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExcursionController extends AbstractController
{
    /**
     * @Route("/excursion", name="excursion")
     */
    public function index(): Response
    {
        return $this->render('excursion/index.html.twig', [
            'controller_name' => 'ExcursionController',
        ]);
    }

    /**
     * @Route("/admin-dashboard/excursion", name="admin-dashboard/excursion")
     */
    public function admin_index(): Response
    {
        return $this->render('excursion/admin_index.html.twig', [
            'controller_name' => 'ExcursionController',
        ]);
    }

}
