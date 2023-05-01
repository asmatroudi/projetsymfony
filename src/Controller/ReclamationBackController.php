<?php

namespace App\Controller;

use App\Entity\Reclamation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('admin/Reclamation')]

class ReclamationBackController extends AbstractController
{
    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/List', name: 'List_Back_Rec')]
    public function List(): Response
    {
        $Reclamations = $this->entityManager->getRepository(Reclamation::class)->findall();
        return $this->render('back/Reclamation/List.html.twig', ['Reclamations' => $Reclamations]);
    }


    #[Route('/ListBad', name: 'ListBad_Back_Rec')]
    public function badWords(): Response
    {
        $Reclamations = $this->entityManager->getRepository(Reclamation::class)->findAll();
        $ListEnglish = [
            'shit',
            'horseshit',
            'in shit',
            'Jesus Christ',
            'Jesus fuck',
            'Jesus H. Christ',
            'Jesus Harold Christ',
            'Jesus wept',
            'Jesus',
            'kike',
            'motherfucker',
            'nigga',
            'nigra',
            'piss',
            'prick',
            'pussy',
            'shit',
            'shit ass',
            'shite',
            'sisterfucker',
            'slut',
            'son of a bitch',
            'son of a whore',
            'spastic',
            'sweet Jesus',
            'turd',
            'twat',
            'wanker',
            'arse',
            'arsehead',
            'arsehole',
            'ass',
            'asshole',
            'bastard',
            'bitch',
            'bloody',
            'bollocks',
            'brotherfucker',
            'bugger',
            'bullshit',
            'child-fucker',
            'Christ on a bike',
            'Christ on a cracker',
            'cock',
            'cocksucker',
            'crap',
            'cunt',
            'damn',
            'damn it',
            'dick',
            'dickhead',
            'dyke',
            'fatherfucker',
            'frigger',
            'fuck',
            'goddamn',
            'godsdamn',
            'hell'
        ];

        $ListFrench = [
            'Putain',
            'Merde',
            'Bordel',
            'Putain de merde',
            'Bordel de merde',
            'Putain de bordel de merde',
            'Ostie',
            'Tabarnak',
            'Crisse',
            'Calisse',
            'Connerie',
            'Sacrament',
            'Connard',
            'Saloperie',
            'Salaud',
            'Salopard',
            'Salope',
            'Pute',
            'Putain',
            'Garce',
            'Traînée',
            'Chatte',
            'Pouffiasse',
            'Pouffe',
            'Plotte',
            'Tas de merde',
            'Gros tas',
            'Trou du cul',
            'Lèche-cul',
            'Couilles',
            'Téteux',
            'Casse-couilles',
            'Casser les couilles or Péter les couilles',
            'Fils de pute',
            'Enculer',
            'Enculé',
            'Branler',
            'Branleu',
            'Emmerder',
            'Emmerdeu',
            'Chier',
            'Chieur',
            'Chiant',
            'Bite',
            'Tête de nœud',
            'Queutard',
            'Metteux',
            'gueule',
            'foutre',
            'crosser',
            'Niquer',
            'Nique',
            'pute'
        ];
        $etat = false;
        $BadReclamations = array();



        foreach ($Reclamations as $Reclamation) {

            //Tester Si une reclamation contient une mauvaise mot en anglais

            // diviser la reclamation en mots 
            $wordsReclamation = explode(" ", strtolower($Reclamation->getReclamation()));

            foreach ($ListEnglish as $badword) {
                if (in_array(strtolower($badword), $wordsReclamation)) {
                    $etat = True;
                }
            }
            //Tester Si une reclamation contient une mauvaise mot en Francais

            foreach ($ListFrench as $badword) {
                if (in_array(strtolower($badword), $wordsReclamation)) {
                    $etat = true;
                }
            }
            // Si la reclamation contient une mauvaise mot on l'ajoute au liste du mauvaise mots 

            if ($etat == True) {
                array_push($BadReclamations, $Reclamation);
            }

            $etat = false;
        }


        return $this->render('back/Reclamation/ListBad.html.twig', ['Reclamations' => $BadReclamations]);
    }
}
