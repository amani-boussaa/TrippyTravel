<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    /**
     * @Route("/admin-dashboard/users", name="admin-dashboard/users")
     */
    public function admin_index(): Response
    {
        return $this->render('users/admin_index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
}
