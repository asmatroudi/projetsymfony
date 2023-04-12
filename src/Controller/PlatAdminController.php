<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\PlatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/plat')]
class PlatAdminController extends AbstractController
{
    #[Route('/', name: 'admin_plat_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $plats = $entityManager
            ->getRepository(Plat::class)
            ->findAll();

        return $this->render('platAdmin/index.html.twig', [
            'plats' => $plats,
        ]);
    }

    #[Route('/new', name: 'admin_plat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $plat = new Plat();
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($plat);
            $entityManager->flush();

            return $this->redirectToRoute('admin_plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('platAdmin/new.html.twig', [
            'plat' => $plat,
            'form' => $form,
        ]);
    }

    #[Route('/{idplat}', name: 'admin_plat_show', methods: ['GET'])]
    public function show(Plat $plat): Response
    {
        return $this->render('platAdmin/show.html.twig', [
            'plat' => $plat,
        ]);
    }

    #[Route('/{idplat}/edit', name: 'admin_plat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Plat $plat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('platAdmin/edit.html.twig', [
            'plat' => $plat,
            'form' => $form,
        ]);
    }

    #[Route('/{idplat}', name: 'admin_plat_delete', methods: ['POST'])]
    public function delete(Request $request, Plat $plat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plat->getIdplat(), $request->request->get('_token'))) {
            $entityManager->remove($plat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_plat_index', [], Response::HTTP_SEE_OTHER);
    }
}
