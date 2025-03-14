<?php

namespace App\Service;

use App\Entity\Space;
use App\Form\AccountingSpaceType;
use App\Form\ProfessionalSpaceType;
use App\Form\RenameSpaceType;
use App\Form\SpaceType;
use App\Form\StatusSpaceType;
use App\Repository\SpaceRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        return $this->formFactory->create(SpaceType::class)->createView();
    }

    public function createStatusSpaceForm()
    {
        return $this->formFactory->create(StatusSpaceType::class)->createView();
    }

    public function createRenameSpaceForms()
    {
        $spaces = $this->getSpaces();
        $forms = [];
        foreach ($spaces as $space) {
            $forms[$space->getId()] = $this->formFactory->create(RenameSpaceType::class, $space)->createView();
        }
        return $forms;
    }

    public function createProfessionalSpaceForms()
    {
        $spaces = $this->getSpaces();
        $forms = [];
        foreach ($spaces as $space) {
            $forms[$space->getId()] = $this->formFactory->create(ProfessionalSpaceType::class, $space)->createView();
        }
        return $forms;
    }

    public function updateProfessionalRecursively(Space $space, bool $professional, EntityManagerInterface $entityManager)
    {
        $space->setProfessional($professional);
        foreach ($space->getChildren() as $child) {
            $this->updateProfessionalRecursively($child, $professional, $entityManager);
        }
    }

    public function createAccountingSpaceForms()
    {
        $spaces = $this->getSpaces();
        $forms = [];
        foreach ($spaces as $space) {
            $forms[$space->getId()] = $this->formFactory->create(AccountingSpaceType::class, $space, ['space_id' => $space->getId()])->createView();
        }
        return $forms;
    }

}
