<?php

namespace App\Service;

use App\Entity\Space;
use App\Form\SpaceType;
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

    public function createSpaceForm(?Space $space = null, ?Space $parent = null)
    {
        $newspace = $space ?? new Space();
        if ($parent) {
            $newspace->setParent($parent);
            $newspace->setProfessional($parent->isProfessional());
        }
        $route = 'app_entity_' . ($space ? 'edit' : 'new');
        $routeParams = $space ? ['id' => $space->getId()] : [];
        $routeParams['class'] = 'space';
        return $this->formFactory->create(
            SpaceType::class,
            $newspace,
            ['action' => $this->router->generate($route, $routeParams)]
        );
    }

    public function createMultipleSpaceForms()
    {
        $spaces = $this->getSpaces();
        $forms = ['new' => ['-1' => $this->createSpaceForm()->createView()]];
        foreach ($spaces as $space) {
            $forms['new'][$space->getId()] = $this->createSpaceForm(parent: $space)->createView();
            $forms['edit'][$space->getId()] = $this->createSpaceForm($space)->createView();
        }
        return $forms;
    }
}
