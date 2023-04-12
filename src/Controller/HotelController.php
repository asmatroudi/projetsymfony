<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use App\Form\CommentaireType;
use App\Form\HotelType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

#[Route('/hotel')]
class HotelController extends AbstractController
{
    #[Route('/', name: 'hotels', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $hotels = $entityManager
            ->getRepository(Hotel::class)
            ->findAll();
        $commentaires = $entityManager
            ->getRepository(Commentaire::class)
            ->findAll();

        return $this->render('hotel/index.html.twig', [
            'hotels' => $hotels,
            'commentaires' => $commentaires,
        ]);
    }

    #[Route('/{idh}', name: 'app_hotel_show', methods: ['GET'])]
    public function show(Hotel $hotel): Response
    {
        return $this->render('hotel/show.html.twig', [
            'hotel' => $hotel,
        ]);
    }

    #[Route('/{id}/comment/add', name: 'app_hotel_comment', methods: ['GET', 'POST'])]
    
    public function addComment(Request $request, Hotel $hotel, EntityManagerInterface $entityManager)
{
    $now = new DateTime();
    $user = $entityManager->find(Utilisateur::class, 21);
    $comment = new Commentaire();
    $comment->setIdHotel($hotel->getIdh());
    $comment->setDateajc($now);
    $comment->setAuteur($user->getIduser());
    $form = $this->createForm(CommentaireType::class, $comment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();
        return $this->redirectToRoute('hotels', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('hotel/comment.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
