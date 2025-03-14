<?php

namespace App\Service;

use App\Form\AccountType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

class AccountService
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private RouterInterface $router
    ) {
    }

    public function createAccountForm()
    {
        return $this->formFactory->create(AccountType::class)->createView();
    }
}
