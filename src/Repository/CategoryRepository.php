<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function getHierarchy(?Category $parent = null): array
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.parent IS NULL')
            ->orderBy('c.name', 'ASC');

        if ($parent) {
            $qb->where('c.parent = :parent')
                ->setParameter('parent', $parent);
        }

        $categories = $qb->getQuery()->getResult();

        foreach ($categories as $category) {
            $category->children = $this->getHierarchy($category);
        }

        return $categories;
    }

    public function getHierarchyChoices(?Category $parent = null, int $level = 0, array &$result = []): array
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC');

        if ($parent === null) {
            $qb->where('c.parent IS NULL');
        } else {
            $qb->where('c.parent = :parent')
                ->setParameter('parent', $parent);
        }

        $categories = $qb->getQuery()->getResult();

        foreach ($categories as $category) {
            $category->setLevel($level); // Ajout d'un niveau pour l'affichage
            $result[] = $category;
            $this->getHierarchyChoices($category, $level + 1, $result);
        }

        return $result;
    }

    private function getChildrenChoices(Category $parent, int $level, array &$result): void
    {
        $children = $this->createQueryBuilder('c')
            ->where('c.parent = :parent')
            ->setParameter('parent', $parent)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();

        foreach ($children as $child) {
            $result[$child->getId()] = str_repeat('–', $level) . ' ' . $child->getName();
            $this->getChildrenChoices($child, $level + 1, $result);
        }
    }

    //    /**
    //     * @return Category[] Returns an array of Category objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Category
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
