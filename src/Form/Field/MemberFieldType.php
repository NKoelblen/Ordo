<?php

namespace App\Form\Field;

use App\Entity\Category;
use App\Entity\Member;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberFieldType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Member::class,
            'choice_label' => 'name',
        ]);
    }
    public function getParent(): string
    {
        return EntityType::class;
    }
}
