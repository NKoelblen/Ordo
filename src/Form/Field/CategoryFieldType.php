<?php

namespace App\Form\Field;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryFieldType extends AbstractType
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Category::class,
            'choices' => $this->categoryRepository->getHierarchyChoices(),
            'choice_label' => function (Category $category) {
                return str_repeat('—', $category->getLevel()) . ' ' . $category->getName();
            },
        ]);
    }
    public function getParent(): string
    {
        return EntityType::class;
    }
}
