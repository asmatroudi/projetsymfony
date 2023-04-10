<?php

namespace App\Controller;

use App\Entity\Activities;
use App\Form\ActivitiesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/activities')]
class ActivitiesController extends AbstractController
{
    #[Route('/', name: 'activities', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $activities = $entityManager
            ->getRepository(Activities::class)
            ->findAll();

        return $this->render('activities/index.html.twig', [
            'activities' => $activities,
        ]);
    }

    #[Route('/{idActivity}', name: 'app_activities_show', methods: ['GET'])]
    public function show(Activities $activity): Response
    {
        return $this->render('activities/show.html.twig', [
            'activity' => $activity,
        ]);
    }
}
