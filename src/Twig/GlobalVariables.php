<?php

namespace App\Twig;

use App\Service\AccountService;
use App\Service\BudgetService;
use App\Service\EntityService;
use App\Service\SpaceService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class GlobalVariables extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private EntityService $entityService,
        private SpaceService $spaceService,
        private AccountService $accountService,
        private BudgetService $budgetService
    ) {
    }

    public function getGlobals(): array
    {
        return [
            'entities' => $this->entityService->getEntities(),
            'spaces' => $this->spaceService->getSpaces(),
            'spaceForm' => $this->spaceService->createSpaceForm(),
            'renameSpaceForms' => $this->spaceService->createRenameSpaceForms(),
            'statusSpaceForm' => $this->spaceService->createStatusSpaceForm(),
            'professionalSpaceForms' => $this->spaceService->createProfessionalSpaceForms(),
            'accountForm' => $this->accountService->createAccountForm(),
            'budgetForm' => $this->budgetService->createBudgetForm()
        ];
    }
}
