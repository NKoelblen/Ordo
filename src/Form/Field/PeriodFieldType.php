<?php

namespace App\Form\Field;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use IntlDateFormatter;
use DateTime;

class PeriodFieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Définition des mois en français avec leur numéro
        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'MMMM');
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $date = new DateTime("1901-$i-01");
            $monthName = ucfirst($formatter->format($date));
            $formattedMonth = sprintf('%02d - %s', $i, $monthName);
            $months[$formattedMonth] = $i;
        }

        $builder
            ->add('month', ChoiceType::class, [
                'label' => 'Mois',
                'choices' => $months,
                'placeholder' => 'Sélectionnez un mois',
            ])
            ->add('year')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null, // Pas lié à une entité spécifique
        ]);
    }
}