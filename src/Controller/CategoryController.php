<?php
namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\SpaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    public function __construct(private SpaceRepository $spaceRepository)
    {
    }

    #[Route('/api/categories/space/{spaceId}', name: 'api_categories_by_space', methods: ['GET'])]
    public function getCategoriesBySpace(CategoryRepository $categoryRepository, int $spaceId): JsonResponse
    {
        $spaceIds = $this->spaceRepository->getAncestorsIds($spaceId);
        $categories = $categoryRepository->getCategoriesBySpaces($spaceIds);

        return $this->json(array_map(fn($category) => [
            'id' => $category->getId(),
            'name' => $category->getName(),
        ], $categories));
    }
}