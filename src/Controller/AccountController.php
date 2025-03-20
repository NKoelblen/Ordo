<?php

namespace App\Controller;

use App\Form\RenameAccountType;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccountController extends AbstractController
{
    public function __construct(
        private AccountRepository $accountRepository
    ) {
    }

    #[Route('/account/{id}/rename', name: 'app_account_rename', methods: ['POST'])]
    public function rename(int $id, Request $request, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory): ?Response
    {
        $account = $this->accountRepository->find($id);
        if (!$account) {
            throw $this->createNotFoundException("Aucun enregistrement trouvé.");
        }
        $form = $formFactory->create(RenameAccountType::class, $account);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/api/account/{id}', name: 'api_account_get', methods: ['GET'])]
    public function getAccount(int $id): JsonResponse
    {
        $account = $this->accountRepository->find($id);
        if (!$account) {
            return new JsonResponse(['error' => 'Account not found'], Response::HTTP_NOT_FOUND);
        }
        $data = [
            'id' => $account->getId(),
            'name' => $account->getName(),
            'spaces' => $account->getSpaceIds(),
        ];

        return new JsonResponse($data);
    }
}
