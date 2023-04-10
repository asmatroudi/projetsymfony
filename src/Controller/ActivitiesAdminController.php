<?php

namespace App\Controller;

use App\Entity\Activities;
use App\Form\ActivitiesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/activities')]
class ActivitiesAdminController extends AbstractController
{
    #[Route('/', name: 'admin_activities_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $activities = $entityManager
            ->getRepository(Activities::class)
            ->findAll();

        return $this->render('activitiesAdmin/index.html.twig', [
            'activities' => $activities,
        ]);
    }

    #[Route('/new', name: 'admin_activities_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $activity = new Activities();
        $form = $this->createForm(ActivitiesType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($activity);
            $entityManager->flush();

            return $this->redirectToRoute('admin_activities_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activitiesAdmin/new.html.twig', [
            'activity' => $activity,
            'form' => $form,
        ]);
    }

    #[Route('/{idActivity}', name: 'admin_activities_show', methods: ['GET'])]
    public function show(Activities $activity): Response
    {
        return $this->render('activitiesAdmin/show.html.twig', [
            'activity' => $activity,
        ]);
    }

    #[Route('/{idActivity}/edit', name: 'admin_activities_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Activities $activity, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActivitiesType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_activities_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activitiesAdmin/edit.html.twig', [
            'activity' => $activity,
            'form' => $form,
        ]);
    }

    #[Route('/{idActivity}', name: 'admin_activities_delete', methods: ['POST'])]
    public function delete(Request $request, Activities $activity, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activity->getIdActivity(), $request->request->get('_token'))) {
            $entityManager->remove($activity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_activities_index', [], Response::HTTP_SEE_OTHER);
    }
}
