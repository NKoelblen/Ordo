<?php

namespace App\Controller;

use App\Service\FieldService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EntityController extends AbstractController
{
    #[Route('/{class}', name: 'app_entity_index', methods: ['GET'])]
    public function index(string $class, EntityManagerInterface $entityManager, FieldService $fieldService): Response
    {
        $entityClass = "App\\Entity\\" . ucfirst($class);
        if (!class_exists($entityClass)) {
            throw $this->createNotFoundException("L'entité '$class' n'existe pas.");
        }

        $items = $entityManager->getRepository($entityClass)->findAll();
        $fields = $fieldService->getFields(ucfirst($class));

        return $this->render(
            'crud/index.html.twig',
            [
                'items' => $items,
                'fields' => $fields,
                'entity' => $entityClass
            ]
        );
    }

    #[Route('/{class}/new', name: 'app_entity_new', methods: ['GET', 'POST'])]
    public function new(string $class, Request $request, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory): Response
    {
        $entityClass = "App\\Entity\\" . ucfirst($class);
        if (!class_exists($entityClass)) {
            throw $this->createNotFoundException("L'entité '$class' n'existe pas.");
        }

        $item = new $entityClass();
        $formTypeClass = "App\\Form\\" . ucfirst($class) . "Type";
        $form = $formFactory->createBuilder($formTypeClass, $item)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($item);
            $entityManager->flush();

            return $this->redirectToRoute('app_entity_index', ['class' => strtolower($class)]);
        }

        return $this->render(
            'crud/new.html.twig',
            [
                'form' => $form->createView(),
                'entityClass' => $entityClass,
            ]
        );
    }

    #[Route('/{class}/{id}', name: 'app_entity_show', methods: ['GET'])]
    public function show(string $class, int $id, EntityManagerInterface $entityManager): Response
    {
        $entityClass = "App\\Entity\\" . ucfirst($class);
        if (!class_exists($entityClass)) {
            throw $this->createNotFoundException("L'entité '$class' n'existe pas.");
        }

        $item = $entityManager->getRepository($entityClass)->find($id);
        if (!$item) {
            throw $this->createNotFoundException("Aucun enregistrement trouvé.");
        }

        return $this->render('crud/show.html.twig', [
            'item' => $item,
        ]);
    }

    #[Route('/{class}/{id}/edit', name: 'app_entity_edit', methods: ['GET', 'POST'])]
    public function edit(string $class, int $id, Request $request, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory): Response
    {
        $entityClass = "App\\Entity\\" . ucfirst($class);
        if (!class_exists($entityClass)) {
            throw $this->createNotFoundException("L'entité '$class' n'existe pas.");
        }

        $item = $entityManager->getRepository($entityClass)->find($id);
        if (!$item) {
            throw $this->createNotFoundException("Aucun enregistrement trouvé.");
        }

        $formTypeClass = "App\\Form\\" . ucfirst($class) . "Type";
        $form = $formFactory->createBuilder($formTypeClass, $item)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_entity_index', ['class' => strtolower($class)]);
        }

        return $this->render(
            'crud/edit.html.twig',
            [
                'form' => $form->createView(),
                'item' => $item,
            ]
        );
    }

    #[Route('/{class}/{id}/delete', name: 'app_entity_delete', methods: ['GET'])]
    public function delete(string $class, int $id, EntityManagerInterface $entityManager): RedirectResponse
    {
        $entityClass = "App\\Entity\\" . ucfirst($class);
        if (!class_exists($entityClass)) {
            throw $this->createNotFoundException("L'entité '$class' n'existe pas.");
        }

        $item = $entityManager->getRepository($entityClass)->find($id);
        if (!$item) {
            throw $this->createNotFoundException("Aucun enregistrement trouvé.");
        }

        $entityManager->remove($item);
        $entityManager->flush();

        return $this->redirectToRoute('app_entity_index', ['class' => strtolower($class)]);
    }
}
