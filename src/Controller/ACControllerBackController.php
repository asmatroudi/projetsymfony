<?php

namespace App\Controller;

use App\Entity\Gouvernorat;
use App\Entity\Articleculturel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\ArticleCulturelleType;


use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin/Article/Culturelle')]
class ACControllerBackController extends AbstractController
{

    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/Ajout', name: 'AC_Back_Ajout')]
    public function ajouter(Request $request): Response
    {
        $Gouvernorats = $this->entityManager->getRepository(Gouvernorat::class)->findAll();
        $dateTime = new \DateTime('now');
        $article = new Articleculturel;
        $form = $this->createForm(ArticleCulturelleType::class, $article, ['method' => 'POST'], ['name' => 'contactform'], ['id' => 'contactform'],);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {



            $imageFile = $form->get('image')->getData();
            // Generate a unique name for the file
            $newFilename = uniqid() . '.' . $imageFile->guessExtension();
            // Move the file to the images directory
            $imageFile->move($this->getParameter('images_directory'), $newFilename);
            $article->setImage($newFilename);
            $article->setDate($dateTime);
            $this->entityManager->persist($article);
            $this->entityManager->flush();
            $Articles = $this->entityManager->getRepository(Articleculturel::class)->findBy([], ['date' => 'DESC']);
            return $this->redirectToRoute('AC_Back_List', array('Articles' => $Articles));
        }

        return $this->render('back/ArticleCulturelle/Ajouter.html.twig', [
            'Gouvernorats' => $Gouvernorats, 'form' => $form->createView()
        ]);
    }

    #[Route('/Modifier/{id}', name: 'AC_Back_Modif')]
    public function Modifier(Request $request,  $id): Response
    {


        $Gouvernorats = $this->entityManager->getRepository(Gouvernorat::class)->findAll();
        $dateTime = new \DateTime('now');
        $article = $this->entityManager->getRepository(Articleculturel::class)->find($id);

        $form = $this->createForm(ArticleCulturelleType::class, $article, ['method' => 'POST'], ['name' => 'contactform'], ['id' => 'contactform'],);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            // Generate a unique name for the file
            if ($imageFile != null) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                // Move the file to the images directory
                $imageFile->move($this->getParameter('images_directory'), $newFilename);
                $article->setImage($newFilename);
            } else {
                $article->setImage($request->request->get('Image2'));
            }




            $article->setDate($dateTime);
            $this->entityManager->persist($article);
            $this->entityManager->flush();
            $Articles = $this->entityManager->getRepository(Articleculturel::class)->findBy([], ['date' => 'DESC']);
            return $this->redirectToRoute('AC_Back_List', array('Articles' => $Articles));
        }




        if ($request->request->count() > 3) {
            $article->setTitre($request->request->get('Titre'));
            $gouv = $this->entityManager->getRepository(Gouvernorat::class)->find($request->request->get('Gouvernorat'));
            $article->setIdGouv($gouv);
            $article->setTempMoyenne($request->request->get('TempsMoyenne'));
            $article->setDescription($request->request->get('Description'));
            $article->setImage($request->request->get('Image'));
            $article->setDate($dateTime);
            $this->entityManager->persist($article);
            $this->entityManager->flush();
            $Articles = $this->entityManager->getRepository(Articleculturel::class)->findAll();

            return $this->redirectToRoute('AC_Back_List', array('Articles' => $Articles));
        }

        $Gouvernorats = $this->entityManager->getRepository(Gouvernorat::class)->findAll();
        return $this->render('back/ArticleCulturelle/Modifier.html.twig', [
            'article' => $article, 'Gouvernorats' => $Gouvernorats, 'form' => $form->createView()
        ]);
    }

    #[Route('/List', name: 'AC_Back_List')]
    public function List(): Response
    {
        $Articles = $this->entityManager->getRepository(Articleculturel::class)->findAll();

        return $this->render('back/ArticleCulturelle/List.html.twig', [
            'Articles' => $Articles
        ]);
    }


    #[Route('/Supprimer/{id}', name: 'AC_Back_Supprimer')]
    public function supprimer($id): Response
    {
        $article = $this->entityManager->getRepository(Articleculturel::class)->find($id);
        $this->entityManager->remove($article);
        $this->entityManager->flush();
        $Articles = $this->entityManager->getRepository(Articleculturel::class)->findAll();

        return $this->redirectToRoute('AC_Back_List', array('Articles' => $Articles));
    }
}
