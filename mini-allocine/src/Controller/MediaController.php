<?php

namespace App\Controller;

use App\Entity\Titre;
use App\Repository\TitreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/titres', name: 'app_media')]
class MediaController extends AbstractController
{
    // private $titres = [

    //     [ 'titre'=>'EndGame','contenu'=>"Le Titan Thanos, ayant réussi à s'approprier les six Pierres d'Infinité et à les réunir sur le Gantelet doré, a pu réaliser son objectif de pulvériser la moitié de la population de l'Univers. Cinq ans plus tard, Scott Lang, alias Ant-Man, parvient à s'échapper de la dimension subatomique où il était coincé. Il propose aux Avengers une solution pour faire revenir à la vie tous les êtres disparus, dont leurs alliés et coéquipiers : récupérer les Pierres d'Infinité dans le passé.",'realisateur'=>'Joe russo','annee-sortie'=>'2019' ],
    //     [ 'titre'=>'The wolf of wall street','contenu'=>"Sa licence de courtier en poche, et les narines déjà pleines de cocaïne, Jordan Belfort est prêt à conquérir Wall Street. Ce jour d'octobre, un krach, le plus important depuis 1929, vient piétiner ses rêves de grandeur. C'est finalement à Long Island qu'il échoue et qu'il monte sa propre affaire de courtage. Son créneau : le hors-cote. Sa méthode : l'arnaque. Son équipe : des vendeurs ou des petits trafiquants.",'realisateur'=>'Martin Scorsese','annee-sortie'=>'2012' ],
    //     [ 'titre'=>'Assignment','contenu'=>"Une criminelle lancée sur les traces du cerveau d'une organisation criminelle se retrouve doublée par un gang de voyous et une chirurgienne.",'realisateur'=>'Walter Hill','annee-sortie'=>'2016' ],
    //     [ 'titre'=>'Le contracteur','contenu'=>"Lorsque le sergent James Harper est involontairement renvoyé de l'armée et privé de sa pension, il se retrouve dans une situation désespérée. Endetté et sans autre alternative pour subvenir aux besoins de sa famille, Harper s'engage dans une armée privée clandestine. Mais lorsque la première mission tourne mal, le soldat d'élite se retrouve traqué et en fuite. En dépit des dangers, il espère rentrer chez lui pour découvrir les véritables motivations de ceux qui l'ont trahi.",'realisateur'=>'Tarik Saleh','annee-sortie'=>'2022' ],
    //     [ 'titre'=>'Sang froid','contenu'=>"La vie tranquille de Nels Coxman s'effondre lorsque son fils bien-aimé meurt dans des circonstances mystérieuses. Sa recherche de la vérité se transforme rapidement en vengeance contre un baron de la drogue psychotique nommé Viking et ses hommes de main minables.",'realisateur'=>'Hans Petter Moland','annee-sortie'=>'2019' ],
    //     [ 'titre'=>'Blacklight','contenu'=>"Travis Block, un agent du FBI, doit faire taire un autre agent qui souhaite révéler à la presse les méthodes du Bureau. Il comprend qu'il est devenu le pion d'une terrible machination. Déterminé à faire éclater la vérité, il se lance dans un combat contre ceux avec lesquels il a l'habitude de travailler. Mais lorsque ses adversaires s'attaquent à ses proches, Travis retourne ses méthodes contre ses anciens employeurs et il n'aura aucune pitié.",'realisateur'=>'Mark Williams','annee-sortie'=>'2022' ],

    // ];

    #[Route('/', name: '_list')]
    public function index(Request $request, TitreRepository $repo): Response
    {
        $titres = $repo->findAll();
        return $this->render('media/index.html.twig', [
            'titres' => $titres,
        ]);
    }

    #[Route('/{id}', name: '_details', requirements: ['id'=>'\d+'])]
    public function details(int $id): Response
    {

        $titre = null;
        return $this->render('media/details.html.twig', [
            'titre' => $titre,
        ]);
    }


    #[Route('/ajouter', name: '_ajouter')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        if($request->isMethod("POST")){
            // get data from form
            $nom = $request->request->get("nom");
            $realisateur = $request->request->get("realisateur");
            $anneeSortie = $request->request->get("annee");
            $contenu = $request->request->get("contenu");
            // create instance
            $titre = (new Titre())->setNom($nom)
                                  ->setRealisateur($realisateur)
                                  ->setAnneeSortie($anneeSortie)
                                  ->setContenu($contenu);
            // Persist
            $em->persist($titre);
            $em->flush();
            // redirect
            return $this->redirectToRoute("app_media_list");

        }
        return $this->render('media/add.html.twig', [ ]);
    }







}
