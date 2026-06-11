<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/admin/categorie')]
final class CategorieController extends AbstractController
{
    #[Route(name: 'admin_categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('admin/categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_categorie_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $photoFondFile */
            $photoFondFile = $form->get('photoFondFile')->getData();

            if ($photoFondFile) {
                $originalFilename = pathinfo($photoFondFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFondFile->guessExtension();

                try {
                    $photoFondFile->move(
                        $this->getParameter('uploads_directory') . '/categories',
                        $newFilename
                    );
                    $categorie->setPhotoFond($newFilename);
                } catch (FileException $e) {
                    // Optionnel : ajouter un message flash d'erreur
                }
            }

            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('admin_categorie_index');
        }

        return $this->render('admin/categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_categorie_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response
    {
        return $this->render('admin/categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Categorie $categorie,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $photoFondFile */
            $photoFondFile = $form->get('photoFondFile')->getData();

            if ($photoFondFile) {
                $originalFilename = pathinfo($photoFondFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFondFile->guessExtension();

                try {
                    $photoFondFile->move(
                        $this->getParameter('uploads_directory') . '/categories',
                        $newFilename
                    );
                    // Optionnel : supprimer l'ancienne image
                    // $oldFile = $this->getParameter('uploads_directory') . '/categories/' . $categorie->getPhotoFond();
                    // if ($categorie->getPhotoFond() && file_exists($oldFile)) {
                    //     unlink($oldFile);
                    // }
                    $categorie->setPhotoFond($newFilename);
                } catch (FileException $e) {
                    // Gestion d'erreur
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin_categorie_index');
        }

        return $this->render('admin/categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
