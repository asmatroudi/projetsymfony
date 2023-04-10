<?php

namespace App\Controller;

use App\Entity\Gouvernorat;
use App\Form\GouvernoratType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/gouvernorat')]
class GouvernoratAdminController extends AbstractController
{
    #[Route('/', name: 'admin_gouvernorat_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $gouvernorats = $entityManager
            ->getRepository(Gouvernorat::class)
            ->findAll();

        return $this->render('gouvernoratAdmin/index.html.twig', [
            'gouvernorats' => $gouvernorats,
        ]);
    }

    #[Route('/new', name: 'admin_gouvernorat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gouvernorat = new Gouvernorat();
        $form = $this->createForm(GouvernoratType::class, $gouvernorat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($gouvernorat);
            $entityManager->flush();

            return $this->redirectToRoute('admin_gouvernorat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gouvernoratAdmin/new.html.twig', [
            'gouvernorat' => $gouvernorat,
            'form' => $form,
        ]);
    }

    #[Route('/{idGouver}', name: 'admin_gouvernorat_show', methods: ['GET'])]
    public function show(Gouvernorat $gouvernorat): Response
    {
        return $this->render('gouvernoratAdmin/show.html.twig', [
            'gouvernorat' => $gouvernorat,
        ]);
    }

    #[Route('/{idGouver}/edit', name: 'admin_gouvernorat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gouvernorat $gouvernorat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GouvernoratType::class, $gouvernorat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_gouvernorat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gouvernoratAdmin/edit.html.twig', [
            'gouvernorat' => $gouvernorat,
            'form' => $form,
        ]);
    }

    #[Route('/{idGouver}', name: 'admin_gouvernorat_delete', methods: ['POST'])]
    public function delete(Request $request, Gouvernorat $gouvernorat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gouvernorat->getIdGouver(), $request->request->get('_token'))) {
            $entityManager->remove($gouvernorat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_gouvernorat_index', [], Response::HTTP_SEE_OTHER);
    }
}
