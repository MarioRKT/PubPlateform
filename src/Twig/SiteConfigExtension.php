<?php

namespace App\Twig;

use App\Repository\SiteConfigRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SiteConfigExtension extends AbstractExtension
{
    private SiteConfigRepository $repository;

    public function __construct(SiteConfigRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('site_config', [$this, 'getConfig']),
        ];
    }

    public function getConfig(): ?\App\Entity\SiteConfig
    {
        return $this->repository->findOneBy([]);
    }
}