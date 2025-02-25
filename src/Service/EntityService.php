<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class EntityService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEntities(): array
    {
        $entities = [
            'Account',
            'Budget',
            'Category',
            'Counterparty',
            'Member',
            'Transaction',
            'Detail',
        ];

        return array_map(fn($entity) => [
            'name' => $entity,
            'route' => 'app_entity_index',
            'params' => ['class' => strtolower($entity)],
        ], $entities);
    }
}