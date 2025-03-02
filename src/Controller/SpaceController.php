<?php

namespace App\Controller;

use App\Entity\Space;
use App\Form\StatusSpaceType;
use App\Repository\SpaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SpaceController extends AbstractController
{
    public function __construct(
        private SpaceRepository $spaceRepository
    ) {
    }

    #[Route('/space/{id}/status', name: 'app_space_status', methods: ['POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory): ?Response
    {
        $item = $this->spaceRepository->find($id);
        if (!$item) {
            throw $this->createNotFoundException("Aucun enregistrement trouvé.");
        }

        $form = $formFactory->create(StatusSpaceType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateStatusRecursively($item, $item->getStatus(), $entityManager);
            $entityManager->flush();

            return $this->redirect($request->headers->get('referer'));
        }
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

    #[Route('/api/space/hierarchy', name: 'api_space_hierarchy', methods: ['POST'])]
    public function updateHierarchy(Request $request, SpaceRepository $spaceRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        /** @var Space $space */
        $space = $spaceRepository->find($data['id']);
        $parent = $data['parentId'] ? $spaceRepository->find($data['parentId']) : null;

        if ($space) {
            $space->setParent($parent);
            $space->removeChild($parent);
            $entityManager->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse(['status' => 'error'], 400);
    }

    private function updateStatusRecursively(Space $space, string $status, EntityManagerInterface $entityManager)
    {
        $space->setStatus($status);
        foreach ($space->getChildren() as $child) {
            $this->updateStatusRecursively($child, $status, $entityManager);
        }
    }
}
