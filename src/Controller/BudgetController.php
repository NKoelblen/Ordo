<?php

namespace App\Controller;

use App\Form\RenameBudgetType;
use App\Repository\BudgetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BudgetController extends AbstractController
{
    public function __construct(
        private BudgetRepository $budgetRepository
    ) {
    }

    #[Route('/budget/{id}/rename', name: 'app_budget_rename', methods: ['POST'])]
    public function rename(int $id, Request $request, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory): ?Response
    {
        $budget = $this->budgetRepository->find($id);
        if (!$budget) {
            throw $this->createNotFoundException("Aucun enregistrement trouvé.");
        }
        $form = $formFactory->create(RenameBudgetType::class, $budget);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/api/budget/{id}', name: 'api_budget_get', methods: ['GET'])]
    public function getBudget(int $id): JsonResponse
    {
        $budget = $this->budgetRepository->find($id);
        if (!$budget) {
            return new JsonResponse(['error' => 'Budget not found'], Response::HTTP_NOT_FOUND);
        }
        $data = [
            'id' => $budget->getId(),
            'amount' => $budget->getAmount(),
            'month' => $budget->getMonth(),
            'year' => $budget->getYear(),
            'category' => $budget->getCategory(),
            'groupMember' => $budget->getGroupMember(),
            'spaces' => $budget->getSpaceIds(),
        ];

        return new JsonResponse($data);
    }
}
