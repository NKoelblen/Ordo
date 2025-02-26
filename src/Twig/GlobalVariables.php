<?php

namespace App\Twig;

use App\Service\EntityService;
use App\Service\SpaceService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class GlobalVariables extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private EntityService $entityService,
        private SpaceService $spaceService
    ) {
    }

    public function getGlobals(): array
    {
        return [
            'entities' => $this->entityService->getEntities(),
            'spaces' => $this->spaceService->getSpaces(),
            'spaceForm' => $this->spaceService->createSpaceForm()->createView(),
        ];
    }
}
