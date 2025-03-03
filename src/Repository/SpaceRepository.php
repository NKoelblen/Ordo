<?php

namespace App\Repository;

use App\Entity\Space;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Space>
 */
class SpaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Space::class);
    }

    public function getHierarchy(?Space $parent = null): array
    {
        $qb = $this->createQueryBuilder('s')
            ->where('s.status = :status')
            ->setParameter('status', 'open')
            ->orderBy('s.name', 'ASC');

        if ($parent) {
            $qb->andwhere('s.parent = :parent')
                ->setParameter('parent', $parent);
        } else {
            $qb->andwhere('s.parent IS NULL');
        }

        $spaces = $qb->getQuery()->getResult();

        foreach ($spaces as $space) {
            $space->children = $this->getHierarchy($space);
        }

        return $spaces;
    }

    public function getHierarchyChoices(?Space $parent = null, int $level = 0, array &$result = []): array
    {
        $qb = $this->createQueryBuilder('s')
            ->where('s.status = :status')
            ->setParameter('status', 'open')
            ->orderBy('s.name', 'ASC');

        if ($parent) {
            $qb->andwhere('s.parent = :parent')
                ->setParameter('parent', $parent);
        } else {
            $qb->andwhere('s.parent IS NULL');
        }

        $spaces = $qb->getQuery()->getResult();

        foreach ($spaces as $space) {
            $space->setLevel($level); // Ajout d'un niveau pour l'affichage
            $result[] = $space;
            $this->getHierarchyChoices($space, $level + 1, $result);
        }

        return $result;
    }

    private function getChildrenChoices(Space $parent, int $level, array &$result): void
    {
        $children = $this->createQueryBuilder('s')
            ->where('s.status = :status')
            ->setParameter('status', 'open')
            ->andwhere('s.parent = :parent')
            ->setParameter('parent', $parent)
            ->orderBy('s.name', 'ASC')
            ->getQuery()
            ->getResult();

        foreach ($children as $child) {
            $result[$child->getId()] = str_repeat('–', $level) . ' ' . $child->getName();
            $this->getChildrenChoices($child, $level + 1, $result);
        }
    }

    //    /**
    //     * @return Space[] Returns an array of Space objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Space
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
