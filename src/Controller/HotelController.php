<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    /**
     * @Route("/hotel", name="hotel")
     */
    public function index(): Response
    {
        return $this->render('hotel/index.html.twig', [
            'controller_name' => 'HotelController',
        ]);
    }
    /**
     * @Route("/admin-dashboard/hotel", name="admin-dashboard/hotel")
     */
    public function admin_index(): Response
    {
        return $this->render('hotel/admin_index.html.twig', [
            'controller_name' => 'HotelController',
        ]);
    }
}
