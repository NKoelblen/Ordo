<?php

namespace App\Form;

use App\Entity\Transaction;
use App\Entity\Detail;
use App\Form\Field\CategoryFieldType;
use App\Form\Field\CustomMoneyFieldType;
use App\Form\Field\MemberFieldType;
use App\Form\Field\PeriodFieldType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount', CustomMoneyFieldType::class)
            ->add('period', PeriodFieldType::class, ['label' => false])
            ->add('transaction', EntityType::class, [
                'class' => Transaction::class,
                'choice_label' => 'id',
            ])
            ->add('category', CategoryFieldType::class)
            ->add('groupMember', MemberFieldType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Detail::class,
        ]);
    }
}
