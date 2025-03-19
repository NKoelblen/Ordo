<?php

namespace App\Form;

use App\Entity\Budget;
use App\Form\Field\CategoryFieldType;
use App\Form\Field\CustomMoneyFieldType;
use App\Form\Field\MemberFieldType;
use App\Form\Field\PeriodFieldType;
use App\Form\Field\SpaceFieldType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount', CustomMoneyFieldType::class)
            ->add('period', PeriodFieldType::class, ['label' => false])
            ->add('category', CategoryFieldType::class)
            ->add('groupMember', MemberFieldType::class)
            ->add('space', SpaceFieldType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Budget::class,
        ]);
    }
}
