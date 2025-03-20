<?php

namespace App\Controller;

use App\Service\FieldService;
use App\Service\SpaceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;

final class EntityController extends AbstractController
{
    public function __construct(private RouterInterface $router, private SpaceService $spaceService)
    {
    }
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

    #[Route('/{class}/new/{parentId}', name: 'app_entity_new', methods: ['GET', 'POST'])]
    public function new(string $class, Request $request, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory, ?int $parentId = null): Response
    {
        $entityClass = "App\\Entity\\" . ucfirst($class);
        if (!class_exists($entityClass)) {
            throw $this->createNotFoundException("L'entité '$class' n'existe pas.");
        }

        $item = new $entityClass();
        $formTypeClass = "App\\Form\\" . ucfirst($class) . "Type";
        $form = $formFactory->createBuilder($formTypeClass, $item)->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($item);
            $entityManager->flush();

            if ($class === 'space') {
                return $this->redirectToRoute('app_entity_show', ['class' => strtolower($class), 'id' => $item->getId()]);
            }

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
    public function show(string $class, int $id, EntityManagerInterface $entityManager, FieldService $fieldService): Response
    {
        $entityClass = "App\\Entity\\" . ucfirst($class);
        if (!class_exists($entityClass)) {
            throw $this->createNotFoundException("L'entité '$class' n'existe pas.");
        }

        $item = $entityManager->getRepository($entityClass)->find($id);
        if (!$item) {
            throw $this->createNotFoundException("Aucun enregistrement trouvé.");
        }

        $fields = $fieldService->getFields(ucfirst($class));

        return $this->render('crud/show.html.twig', [
            'item' => $item,
            'fields' => $fields,
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
        $form = $formFactory->createBuilder($formTypeClass, $item)->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($class === 'space') {
                $this->spaceService->updateProfessionalRecursively($item, $item->isProfessional(), $entityManager);
            }

            $entityManager->flush();

            if ($class === 'space') {
                $referer = $request->headers->get('referer');
                if ($referer) {
                    return $this->redirect($referer);
                }
            }
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

    #[Route('/{class}/{id}/delete', name: 'app_entity_delete', methods: ['POST', 'GET'])]
    public function delete(string $class, int $id, EntityManagerInterface $entityManager, Request $request): RedirectResponse
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

        if ($class === 'space') {
            $referer = $request->headers->get('referer');

            if ($referer) {
                $path = parse_url($referer, PHP_URL_PATH);

                if ($entityManager->getRepository($entityClass)->find(explode('/', $path)[2])) {
                    return $this->redirect($referer);
                } else {
                    return $this->redirectToRoute('app_home');
                }
            }
        }
        return $this->redirectToRoute('app_entity_index', ['class' => strtolower($class)]);
    }
}
