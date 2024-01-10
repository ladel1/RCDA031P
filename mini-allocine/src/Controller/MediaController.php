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

    #[Route('/', name: '_list')]
    public function index(Request $request, TitreRepository $repo): Response
    {
        // query pour GET
        $search = $request->query->get("s");
        
        
        if($search){
            $titres = $repo->search($search);
        }else{
            $titres = $repo->findBy([],["anneeSortie"=>"DESC"],10,1);
        }

        return $this->render('media/index.html.twig', [
            'titres' => $titres,
        ]);
    }

    #[Route('/{id}', name: '_details', requirements: ['id'=>'\d+'])]
    public function details(Titre $titre): Response
    {
        // $titre =  $repo->find($id);

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
