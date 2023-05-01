<?php

namespace App\Controller;

use App\Entity\Gouvernorat;
use App\Entity\Articleculturel;
use App\Form\ArticleCulturelleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Dompdf\Dompdf;
use Dompdf\Options;


#[Route('/Article/Culturelle')]
class ArticleCulturelleController extends AbstractController
{
    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/Ajout', name: 'AC_Ajout')]
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

        return $this->render('front/ArticleCulturelle/Ajout.html.twig', [
            'Gouvernorats' => $Gouvernorats, 'form' => $form->createView()
        ]);
    }

    #[Route('/Modifier/{id}', name: 'AC_Modif')]
    public function Modifier(Request $request,  $id): Response
    {
        $Gouvernorats = $this->entityManager->getRepository(Gouvernorats::class)->findAll();
        $dateTime = new \DateTime('now');
        $article = $this->entityManager->getRepository(Articleculturel::class)->find($id);

        $form = $this->createForm(ArticleCulturelleType::class, $article, ['method' => 'POST'], ['name' => 'contactform'], ['id' => 'contactform'],);
        $form->handleRequest($request);

        $dateTime = new \DateTime('now');
        if ($request->request->count() > 3) {
            $article->setTitre($request->request->get('Titre'));
            $gouv = $this->entityManager->getRepository(Gouvernorats::class)->find($request->request->get('Gouvernorat'));
            $article->setIdGouv($gouv);
            $article->setTempMoyenne($request->request->get('TempsMoyenne'));
            $article->setDescription($request->request->get('Description'));
            $article->setImage($request->request->get('Image'));
            $article->setDate($dateTime);
            $this->entityManager->persist($article);
            $this->entityManager->flush();
        }

        $Gouvernorats = $this->entityManager->getRepository(Gouvernorats::class)->findAll();
        return $this->render('front/ArticleCulturelle/Modifier.html.twig', [
            'article' => $article, 'Gouvernorats' => $Gouvernorats, 'form' => $form->createView()
        ]);
    }

    #[Route('/Supprimer/{id}', name: 'AC_Supprimer')]
    public function supprimer($id): Response
    {
        $article = $this->entityManager->getRepository(Articleculturel::class)->find($id);
        $this->entityManager->remove($article);
        $this->entityManager->flush();
        $Articles = $this->entityManager->getRepository(Articleculturel::class)->findAll();
        return $this->render('front/ArticleCulturelle/List.html.twig', [
            'Articles' => $Articles
        ]);
    }



    #[Route('/List', name: 'AC_List')]
    public function List(): Response
    {
        $Articles = $this->entityManager->getRepository(Articleculturel::class)->findBy([], ['date' => 'DESC']);
        return $this->render('front/ArticleCulturelle/List.html.twig', [
            'Articles' => $Articles
        ]);
    }


    #[Route('/consulter/{id}', name: 'AC_Consulter')]
    public function consult($id): Response
    {
        $article = $this->entityManager->getRepository(Articleculturel::class)->find($id);

        $Articles = $this->entityManager->getRepository(Articleculturel::class)->findAll();
        return $this->render('front/ArticleCulturelle/Consulter.html.twig', [
            'article' => $article
        ]);
    }




    #[Route('/PDF/{id}', name: 'PDF')]
    public function exportPdf($id)
    {
        $article = $this->entityManager->getRepository(Articleculturel::class)->find($id);

        //configuration des Parmaètres du PDF
        $options = new Options();
        $options->set('defaultFont', 'arial', ['isRemoteEnabled' => TRUE]);
        $options->set('isRemoteEnabled', true);

        //$options->setIsRemoteEnabled(True);
        $dompdf = new Dompdf($options);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);

        // Création du PDF 

        $html = $this->renderView('front/ArticleCulturelle/Pdf.html.twig', ['article' => $article]);
        $dompdf->set_option('isRemoteEnabled', TRUE);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Préparation du fichier de téléchargement 
        $fichier =  $article->getTitre() . '.pdf';

        // envoie au navigateur dans le télechargement 
        $dompdf->stream($fichier, ['attachement' => TRUE]);
        return new Response();
    }
}
