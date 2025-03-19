<?php

namespace App\Form;

use App\Entity\Category;
use App\Form\Field\SpacesFieldType;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('parent', EntityType::class, [
                'class' => Category::class,
                'choices' => $this->categoryRepository->getHierarchyChoices(),
                'choice_label' => function (Category $category) {
                    return str_repeat('—', $category->getLevel()) . ' ' . $category->getName();
                },
                'required' => false,
            ])
            ->add('spaces', SpacesFieldType::class, )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
