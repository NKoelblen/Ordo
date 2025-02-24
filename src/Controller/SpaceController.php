<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/space')]
final class SpaceController extends AbstractController
{
    #[Route('/new', name: 'app_space_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
    }

    #[Route('/{id}', name: 'app_space_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
    }

    #[Route('/{id}/edit', name: 'app_space_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
    }

    #[Route('/{id}/delete', name: 'app_space_delete', methods: ['GET'])]
    public function delete(int $id, EntityManagerInterface $entityManager): RedirectResponse
    {
    }
}
