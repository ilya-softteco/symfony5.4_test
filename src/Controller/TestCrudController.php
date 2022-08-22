<?php

namespace App\Controller;

use App\Entity\TestCrud;
use App\Form\TestCrudType;
use App\Repository\TestCrudRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/test/crud')]
class TestCrudController extends AbstractController
{
    #[Route('/', name: 'app_test_crud_index', methods: ['GET'])]
    public function index(TestCrudRepository $testCrudRepository): Response
    {
        return $this->render('test_crud/index.html.twig', [
            'test_cruds' => $testCrudRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_test_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TestCrudRepository $testCrudRepository): Response
    {
        $testCrud = new TestCrud();
        $form = $this->createForm(TestCrudType::class, $testCrud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testCrudRepository->add($testCrud, true);

            return $this->redirectToRoute('app_test_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('test_crud/new.html.twig', [
            'test_crud' => $testCrud,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_test_crud_show', methods: ['GET'])]
    public function show(TestCrud $testCrud): Response
    {
        return $this->render('test_crud/show.html.twig', [
            'test_crud' => $testCrud,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_test_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TestCrud $testCrud, TestCrudRepository $testCrudRepository): Response
    {
        $form = $this->createForm(TestCrudType::class, $testCrud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testCrudRepository->add($testCrud, true);

            return $this->redirectToRoute('app_test_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('test_crud/edit.html.twig', [
            'test_crud' => $testCrud,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_test_crud_delete', methods: ['POST'])]
    public function delete(Request $request, TestCrud $testCrud, TestCrudRepository $testCrudRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$testCrud->getId(), $request->request->get('_token'))) {
            $testCrudRepository->remove($testCrud, true);
        }

        return $this->redirectToRoute('app_test_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
