<?php

namespace App\Controller;

use App\Entity\SiteConfig;
use App\Form\SiteConfigType;
use App\Repository\SiteConfigRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

// #[Route('/admin/site-config')]
// final class SiteConfigController extends AbstractController
// {
//     #[Route('/', name: 'admin_site_config_index', methods: ['GET'])]
//     public function index(
//         SiteConfigRepository $repository,
//         EntityManagerInterface $entityManager
//     ): Response {
//         $config = $repository->findOneBy([]);
//         if (!$config) {
//             $config = new SiteConfig();
//             $config->setTitrePage('Mon site');
//             $config->setCopyright('© Mon site');
//             $config->setLienSiteWeb('http://localhost');
//             $config->setActivationPaiement(false);
//             $config->setNbrMaxMenu(5);
//             $entityManager->persist($config);
//             $entityManager->flush();
//         }

//         return $this->redirectToRoute('admin_site_config_edit', ['id' => $config->getId()]);
//     }

//     #[Route('/{id}/edit', name: 'admin_site_config_edit', methods: ['GET', 'POST'])]
//     public function edit(
//         Request $request,
//         SiteConfig $siteConfig,
//         EntityManagerInterface $entityManager,
//         SluggerInterface $slugger
//     ): Response {
//         $form = $this->createForm(SiteConfigType::class, $siteConfig);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             // Gestion de l'upload du logo
//             $logoFile = $form->get('logoFile')->getData();
//             if ($logoFile) {
//                 $originalFilename = pathinfo($logoFile->getClientOriginalName(), PATHINFO_FILENAME);
//                 $safeFilename = $slugger->slug($originalFilename);
//                 $newFilename = $safeFilename . '-' . uniqid() . '.' . $logoFile->guessExtension();
//                 try {
//                     $logoFile->move(
//                         $this->getParameter('uploads_directory') . '/site',
//                         $newFilename
//                     );
//                 } catch (FileException $e) {
//                     // gestion d'erreur
//                 }
//                 // On supprime l'ancien logo si besoin (optionnel)
//                 $siteConfig->setLogo($newFilename);
//             }

//             // Gestion de l'upload du favicon
//             $faviconFile = $form->get('faviconFile')->getData();
//             if ($faviconFile) {
//                 $originalFilename = pathinfo($faviconFile->getClientOriginalName(), PATHINFO_FILENAME);
//                 $safeFilename = $slugger->slug($originalFilename);
//                 $newFilename = $safeFilename . '-' . uniqid() . '.' . $faviconFile->guessExtension();
//                 try {
//                     $faviconFile->move(
//                         $this->getParameter('uploads_directory') . '/site',
//                         $newFilename
//                     );
//                 } catch (FileException $e) {
//                     // ...
//                 }
//                 $siteConfig->setFavicon($newFilename);
//             }

//             $entityManager->flush();

//             return $this->redirectToRoute('admin_site_config_index');
//         }

//         return $this->render('site_config/edit.html.twig', [
//             'site_config' => $siteConfig,
//             'form' => $form,
//         ]);
//     }
// }
