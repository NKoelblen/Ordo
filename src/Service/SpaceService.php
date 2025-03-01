<?php

namespace App\Service;

use App\Entity\Space;
use App\Form\SpaceType;
use App\Form\StatusSpaceType;
use App\Repository\SpaceRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

class SpaceService
{
    public function __construct(
        private SpaceRepository $spaceRepository,
        private FormFactoryInterface $formFactory,
        private RouterInterface $router
    ) {
    }

    public function getSpaces(): array
    {
        return $this->spaceRepository->findBy([], ['parent' => 'ASC', 'name' => 'ASC']);
    }

    public function createSpaceForm()
    {
        return $this->formFactory->create(SpaceType::class);
    }

    public function createStatusSpaceForm()
    {
        return $this->formFactory->create(StatusSpaceType::class);
    }
}
