<?php

namespace App\Controller;

use App\Entity\Gouvernorat;
use App\Form\GouvernoratType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gouvernorat')]
class GouvernoratController extends AbstractController
{
    #[Route('/', name: 'gouvernorats', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $gouvernorats = $entityManager
            ->getRepository(Gouvernorat::class)
            ->findAll();

        return $this->render('gouvernorat/index.html.twig', [
            'gouvernorats' => $gouvernorats,
        ]);
    }

    #[Route('/{idGouver}', name: 'app_gouvernorat_show', methods: ['GET'])]
    public function show(Gouvernorat $gouvernorat): Response
    {
        return $this->render('gouvernorat/show.html.twig', [
            'gouvernorat' => $gouvernorat,
        ]);
    }
}
