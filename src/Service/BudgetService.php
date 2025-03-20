<?php

namespace App\Service;

use App\Form\BudgetType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

class BudgetService
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private RouterInterface $router
    ) {
    }

    public function createBudgetForm()
    {
        return $this->formFactory->create(BudgetType::class)->createView();
    }
}
