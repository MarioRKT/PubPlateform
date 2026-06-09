<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserHomeController extends AbstractController
{
    #[Route('/user/home', name: 'user_home', methods: ['GET'])]
    public function home(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('user/home.html.twig');
    }
}