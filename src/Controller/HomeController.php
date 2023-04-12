<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('front/home.html.twig', [
            'controller_name' => 'home',
        ]);
    }
    
    // #[Route('/services', name: 'services')]
    // public function services(): Response
    // {
    //     return $this->render('front/services.html.twig', [
    //         'controller_name' => 'services',
    //     ]);
    // }
    
    // #[Route('/events', name: 'events')]
    // public function events(): Response
    // {
    //     return $this->render('front/events.html.twig', [
    //         'controller_name' => 'events',
    //     ]);
    // }
    
    #[Route('/aboutus', name: 'aboutus')]
    public function aboutus(): Response
    {
        return $this->render('front/aboutus.html.twig', [
            'controller_name' => 'aboutus',
        ]);
    }
    
    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('front/contact.html.twig', [
            'controller_name' => 'contact',
        ]);
    }
}
