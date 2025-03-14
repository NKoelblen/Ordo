<?php

namespace App\Form\Field;

use App\Entity\Space;
use App\Repository\SpaceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpacesFieldType extends AbstractType
{
    public function __construct(private SpaceRepository $spaceRepository)
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Space::class,
            'choices' => $this->spaceRepository->getHierarchyChoices(),
            'choice_label' => function (Space $space) {
                return str_repeat('—', $space->getLevel()) . ' ' . $space->getName();
            },
            'multiple' => true,
            'expanded' => true,
            'required' => false,
        ]);
    }
    public function getParent(): string
    {
        return EntityType::class;
    }
}
