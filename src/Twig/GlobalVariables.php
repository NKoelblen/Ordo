<?php

namespace App\Twig;

use App\Service\EntityService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class GlobalVariables extends AbstractExtension implements GlobalsInterface
{
    private EntityService $entityService;

    public function __construct(EntityService $entityService)
    {
        $this->entityService = $entityService;
    }

    public function getGlobals(): array
    {
        return [
            'entities' => $this->entityService->getEntities(),
        ];
    }
}
