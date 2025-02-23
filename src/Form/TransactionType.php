<?php

namespace App\Form;

use App\Entity\Account;
use App\Entity\Counterparty;
use App\Entity\Transaction;
use App\Form\Field\CustomMoneyFieldType;
use App\Form\Field\SpacesFieldType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debit', CustomMoneyFieldType::class)
            ->add('credit', CustomMoneyFieldType::class)
            ->add('type')
            ->add('description')
            ->add('operationDate', null, [
                'widget' => 'single_text',
            ])
            ->add('emissionDate', null, [
                'widget' => 'single_text',
            ])
            ->add('account', EntityType::class, [
                'class' => Account::class,
                'choice_label' => 'id',
            ])
            ->add('spaces', SpacesFieldType::class)
            ->add('counterparty', EntityType::class, [
                'class' => Counterparty::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
