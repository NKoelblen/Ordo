<?php

namespace App\Form;

use App\Entity\Space;
use App\Repository\SpaceRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpaceType extends AbstractType
{
    public function __construct(private SpaceRepository $spaceRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, [
                'required' => false,
                'mapped' => false,
            ])
            ->add('name')
            ->add(child: 'professional', options: [
                'required' => false,
            ])
            ->add('parent', EntityType::class, [
                'class' => Space::class,
                'choices' => $this->spaceRepository->getHierarchyChoices(),
                'choice_label' => function (Space $space) {
                    return str_repeat('—', $space->getLevel()) . ' ' . $space->getName();
                },
                'required' => false,
            ])
            ->add('status', HiddenType::class, [
                'data' => 'open'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Space::class,
        ]);
    }
}
