<?php

namespace App\Controller;

use App\Entity\Titre;
use App\Form\TitreType;
use App\Repository\TitreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function Symfony\Component\Clock\now;

#[Route('/titres', name: 'app_media')]
class MediaController extends AbstractController
{

    #[Route('/', name: '_list')]
    public function index(Request $request, TitreRepository $repo): Response
    {
        // query pour GET
        $search = $request->query->get("s");                
        if($search){
            
            $conditions['nom'] = $request->query->get("nom")==="on";
            $conditions['realisateur'] = $request->query->get("realisateur")==="on";
            $conditions['contenu'] = $request->query->get("contenu")==="on";
           
            $titres = $repo->search($search,$conditions);
        }else{
            $titres = $repo->findBy([],["anneeSortie"=>"DESC"],10,0);
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
        $titre = new Titre();
        
        $form = $this->createForm(TitreType::class,$titre);
        // pour persister le formulaire 
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){            
            $em->persist($titre);
            $em->flush();
            // message
            $this->addFlash("success","Titre créé!");
            // redirection 
            return $this->redirectToRoute("app_media_list");
        }
        return $this->render('media/add.html.twig', [ "titreForm"=>$form->createView() ]);
    }

    #[Route('/supprimer', name: '_supprimer')]
    public function delete(Request $request,EntityManagerInterface $em){        
        $idTitre = $request->request->get("delete-titre");
        $csrfToken = $request->request->get("csrf_token");
        if($request->isMethod("POST") && !empty($idTitre) && $this->isCsrfTokenValid("supp_titre_".$idTitre,$csrfToken)){
            $titre = $em->find(Titre::class,$idTitre);
            $em->remove($titre);
            $em->flush();
            $this->addFlash("success","Titre supprimé!");
        }
        return $this->redirectToRoute("app_media_list");
    }

}
