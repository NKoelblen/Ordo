<?php

namespace App\Form;

use App\Entity\Category;
use App\Form\Field\CategoryFieldType;
use App\Form\Field\SpacesFieldType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentCategory = $options['current_item'];

        $builder
            ->add('name')
            ->add('parent', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => false,
                'query_builder' => function (EntityRepository $er) use ($currentCategory) {
                    $qb = $er->createQueryBuilder('s');
                    if ($currentCategory) {
                        $qb->where('s.id != :currentSpace')
                            ->setParameter('currentSpace', $currentCategory->getId());
                    }
                    return $qb;
                },
            ])
            ->add('spaces', SpacesFieldType::class, )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'current_item' => null,
        ]);
    }
}
