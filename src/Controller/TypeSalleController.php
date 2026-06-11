<?php

namespace App\Controller;

use App\Entity\TypeSalle;
use App\Form\TypeSalleType;
use App\Repository\TypeSalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/type-salle')]
final class TypeSalleController extends AbstractController
{
    #[Route('/', name: 'admin_type_salle_index', methods: ['GET'])]
    public function index(TypeSalleRepository $typeSalleRepository): Response
    {
        return $this->render('admin/type_salle/index.html.twig', [
            'type_salles' => $typeSalleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_type_salle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeSalle = new TypeSalle();
        $form = $this->createForm(TypeSalleType::class, $typeSalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeSalle);
            $entityManager->flush();

            return $this->redirectToRoute('admin_type_salle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_salle/new.html.twig', [
            'type_salle' => $typeSalle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_type_salle_show', methods: ['GET'])]
    public function show(TypeSalle $typeSalle): Response
    {
        return $this->render('admin/type_salle/show.html.twig', [
            'type_salle' => $typeSalle,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_type_salle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeSalle $typeSalle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeSalleType::class, $typeSalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_type_salle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_salle/edit.html.twig', [
            'type_salle' => $typeSalle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_type_salle_delete', methods: ['POST'])]
    public function delete(Request $request, TypeSalle $typeSalle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeSalle->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($typeSalle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_type_salle_index', [], Response::HTTP_SEE_OTHER);
    }
}
