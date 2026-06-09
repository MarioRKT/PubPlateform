<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function dashboard(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $userRepository->findAll();
        $totalUsers = count($users);
        $adminCount = count(array_filter($users, fn($u) => in_array('ROLE_ADMIN', $u->getRoles())));    

        return $this->render('admin/dashboard.html.twig', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'adminCount' => $adminCount,
        ]);
    }
}