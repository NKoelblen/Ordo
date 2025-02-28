<?php

namespace App\Controller;

use App\Entity\Space;
use App\Repository\SpaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SpaceController extends AbstractController
{
    public function __construct(
        private SpaceRepository $spaceRepository
    ) {
    }

    #[Route('/api/space/{id}', name: 'api_space_get', methods: ['GET'])]
    public function getSpace(int $id): JsonResponse
    {
        $space = $this->spaceRepository->find($id);
        if (!$space) {
            return new JsonResponse(['error' => 'Space not found'], Response::HTTP_NOT_FOUND);
        }
        $data = [
            'id' => $space->getId(),
            'name' => $space->getName(),
            'professional' => $space->isProfessional(),
            'parent' => $space->getParent() ? $space->getParent()->getId() : null,
        ];

        return new JsonResponse($data);
    }
}
