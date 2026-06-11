<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Form\SalleType;
use App\Repository\SalleRepository;
use App\Repository\TypeSalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/admin/salle')]
final class SalleController extends AbstractController
{
    #[Route('/', name: 'admin_salle_index', methods: ['GET'])]
    public function index(
        SalleRepository $salleRepository,
        TypeSalleRepository $typeSalleRepository
    ): Response {
        return $this->render('admin/salle/index.html.twig', [
            'salles' => $salleRepository->findAll(),
            'types_salle' => $typeSalleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_salle_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $salle = new Salle();
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $apercuFile */
            $apercuFile = $form->get('apercuFile')->getData();
            if ($apercuFile) {
                $originalFilename = pathinfo($apercuFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $apercuFile->guessExtension();
                try {
                    $apercuFile->move(
                        $this->getParameter('uploads_directory') . '/salles',
                        $newFilename
                    );
                    $salle->setApercu($newFilename);
                } catch (FileException $e) {
                    // erreur
                }
            }

            $entityManager->persist($salle);
            $entityManager->flush();

            return $this->redirectToRoute('admin_salle_index');
        }

        return $this->render('admin/salle/new.html.twig', [
            'salle' => $salle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_salle_show', methods: ['GET'])]
    public function show(Salle $salle): Response
    {
        return $this->render('admin/salle/show.html.twig', [
            'salle' => $salle,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_salle_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Salle $salle,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $apercuFile */
            $apercuFile = $form->get('apercuFile')->getData();

            if ($apercuFile) {
                $originalFilename = pathinfo($apercuFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $apercuFile->guessExtension();

                try {
                    $apercuFile->move(
                        $this->getParameter('uploads_directory') . '/salles',
                        $newFilename
                    );
                    // Optionnel : supprimer l’ancienne image si elle existe
                    // $oldFile = $this->getParameter('uploads_directory') . '/salles/' . $salle->getApercu();
                    // if ($salle->getApercu() && file_exists($oldFile)) {
                    //     unlink($oldFile);
                    // }
                    $salle->setApercu($newFilename);
                } catch (FileException $e) {
                    // Gérer l’erreur (log, message flash…)
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin_salle_index');
        }

        return $this->render('admin/salle/edit.html.twig', [
            'salle' => $salle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_salle_delete', methods: ['POST'])]
    public function delete(Request $request, Salle $salle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $salle->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($salle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_salle_index', [], Response::HTTP_SEE_OTHER);
    }
}
