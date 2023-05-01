<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Utilisateur;
use App\Form\ReclamationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Security;


#[Route('/Reclamation')]

class ReclamationController extends AbstractController
{

    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }





    #[Route('/Ajout', name: 'Ajout_Rec')]
    public function ajouter(Security $security,Request $request,  MailerInterface $mailer): Response
    {


        $dateTime = new \DateTime('now');
        $CurrentUSer = $security->getUser();

        $Reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $Reclamation, ['method' => 'POST'],);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $Reclamation->setIdUser($CurrentUSer);
            $Reclamation->setTraitement(false);
            $Reclamation->setDaterec($dateTime);
            $this->entityManager->persist($Reclamation);
            $this->entityManager->flush();


            // bloc Mailing 

            $email = (new Email())
                ->from('Tounesna2023@gmail.com')
                ->to($CurrentUSer->getEmail())
                ->subject('Reclamation!')
                ->html('<p>Votre reclamation va être traiter dans les cours délais!</p>');
            /** @var Symfony\Component\Mailer\SentMessage $sentEmail */


            $sentEmail = $mailer->send($email);

            //Fin bloc Mailing    



            return $this->redirectToRoute('List_Rec');
        }

        return $this->render('front/Reclamation/Ajout.html.twig', [
            'user' => $CurrentUSer, 'form' => $form->createView()
        ]);
    }

    #[Route('/modifier/{id}', name: 'Modifier_Rec')]
    public function modifier(Security $security,Request $request, $id): Response
    {
        $CurrentUSer = $security->getUser();
        $Reclamation = $this->entityManager->getRepository(Reclamation::class)->find($id);
        $form = $this->createForm(ReclamationType::class, $Reclamation, ['method' => 'POST'],);
        $form->handleRequest($request);
        $dateTime = new \DateTime('now');
        if ($form->isSubmitted() && $form->isValid()) {
            $Reclamation->setIdUser($CurrentUSer);
            $Reclamation->setTraitement(false);
            $this->entityManager->persist($Reclamation);
            $this->entityManager->flush();
            return $this->redirectToRoute('List_Rec');
        }

        return $this->render('front/Reclamation/Modifier.html.twig', [
            'user' => $CurrentUSer, 'reclamation' => $Reclamation, 'form' => $form->createView()
        ]);
    }


    #[Route('/List', name: 'List_Rec')]
    public function List(Security $security): Response
    {

        $CurrentUser = $security->getUser();
        $Reclamations = $this->entityManager->getRepository(Reclamation::class)->findBy(['idUser' => $CurrentUser], ['daterec' => 'ASC']);
        return $this->render('front/Reclamation/List.html.twig', ['Reclamations' => $Reclamations]);
    }

    #[Route('/Supprimer/{id}', name: 'Supprimer_Rec')]
    public function supprimer($id): Response
    {
        $Reclamation = $this->entityManager->getRepository(Reclamation::class)->find($id);
        $this->entityManager->remove($Reclamation);
        $this->entityManager->flush();
        return $this->redirectToRoute('List_Rec');
    }
}
