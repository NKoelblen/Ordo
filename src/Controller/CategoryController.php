<?php
namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/api/categories/space/{spaceId}', name: 'api_categories_by_space', methods: ['GET'])]
    public function getCategoriesBySpace(CategoryRepository $categoryRepository, int $spaceId): JsonResponse
    {
        $categories = $categoryRepository->createQueryBuilder('c')
            ->innerJoin('c.spaces', 's')
            ->where('s.id = :spaceId')
            ->setParameter('spaceId', $spaceId)
            ->getQuery()
            ->getResult();

        return $this->json(array_map(fn($category) => [
            'id' => $category->getId(),
            'name' => $category->getName(),
        ], $categories));
    }
}