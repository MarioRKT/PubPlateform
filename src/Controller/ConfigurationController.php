<?php

namespace App\Controller;

use App\Entity\SiteConfig;
use App\Form\SiteConfigType;
use App\Repository\MenuRepository;
use App\Repository\SiteConfigRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/configuration', name: 'admin_configuration_')]
class ConfigurationController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        MenuRepository $menuRepository,
        SiteConfigRepository $siteConfigRepository,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        // --- Gestion de la configuration du site ---
        $config = $siteConfigRepository->findOneBy([]);
        if (!$config) {
            $config = new SiteConfig();
            $config->setTitrePage('Mon site');
            $config->setCopyright('© Mon site');
            $config->setLienSiteWeb('http://localhost');
            $config->setActivationPaiement(false);
            $config->setNbrMaxMenu(5);
            $entityManager->persist($config);
            $entityManager->flush();
        }

        $form = $this->createForm(SiteConfigType::class, $config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Uploads logo / favicon (même logique que dans SiteConfigController::edit)
            $logoFile = $form->get('logoFile')->getData();
            if ($logoFile) {
                $originalFilename = pathinfo($logoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$logoFile->guessExtension();
                try {
                    $logoFile->move(
                        $this->getParameter('uploads_directory').'/site',
                        $newFilename
                    );
                    $config->setLogo($newFilename);
                } catch (\Exception $e) {
                    // gestion d'erreur simple
                }
            }

            $faviconFile = $form->get('faviconFile')->getData();
            if ($faviconFile) {
                $originalFilename = pathinfo($faviconFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$faviconFile->guessExtension();
                try {
                    $faviconFile->move(
                        $this->getParameter('uploads_directory').'/site',
                        $newFilename
                    );
                    $config->setFavicon($newFilename);
                } catch (\Exception $e) {
                    // ...
                }
            }

            $entityManager->flush();
            $this->addFlash('success', 'Configuration mise à jour.');
            return $this->redirectToRoute('admin_configuration_index');
        }

        // --- Récupération des menus ---
        $menus = $menuRepository->findBy([], ['ordre' => 'ASC']);

        return $this->render('admin/configuration/index.html.twig', [
            'form'   => $form->createView(),
            'config' => $config,
            'menus'  => $menus,
        ]);
    }
}