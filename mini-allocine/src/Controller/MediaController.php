<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Titre;
use App\Form\AvisType;
use App\Form\TitreType;
use App\Repository\AvisRepository;
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

    #[Route('/{page}', name: '_list', requirements:['page'=>'\d+'])]
    public function index(Request $request, TitreRepository $repo,int $page=null): Response
    {
        // query pour GET
        $search = $request->query->get("s");                
        if($search){            
            $conditions['nom'] = $request->query->get("nom")==="on";
            $conditions['realisateur'] = $request->query->get("realisateur")==="on";
            $conditions['contenu'] = $request->query->get("contenu")==="on";
           
            $titres = $repo->search($search,$conditions);
        }else if($page){
            $titres = $repo->pagination($page);
        }else{
            $titres = $repo->findAll();
        }
        

        return $this->render('media/index.html.twig', [
            'titres' => $titres,
            'nbrPage' => $repo->count([])/4
        ]);
    }

    #[Route('/{id}', name: '_details', requirements: ['id'=>'\d+'])]
    public function details( Titre $titre,
                             Request $request,
                             EntityManagerInterface $em,
                             AvisRepository $avisRepo
                             ): Response
    {

        // créer une instance avis
        $avis = new Avis();
        $avis->setTitre($titre);

        $avisForm = $this->createForm(AvisType::class,$avis);
        $avisForm->handleRequest($request);

        if($avisForm->isSubmitted() && $avisForm->isValid()){
            $em->persist($avis);
            $em->flush();            
        }

        // chercher les avis
        $listeAvis = $avisRepo->findBy(['titre'=>$titre]);
        
        return $this->render('media/details.html.twig', [
            'titre' => $titre,
            'avisForm'=>$avisForm->createView(),
            'listeAvis'=>$listeAvis
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

    #[Route('/modifier/{id}', name: '_modifier', requirements: ['id'=>'\d+'])]
    public function edit(Request $request,Titre $titre, EntityManagerInterface $em): Response
    {        
        $form = $this->createForm(TitreType::class,$titre);
        // pour persister le formulaire 
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){                        
            $em->flush();
            // message
            $this->addFlash("success","Titre modifié!");
            // redirection 
            return $this->redirectToRoute("app_media_list");
        }
        return $this->render('media/edit.html.twig', [ "titreForm"=>$form->createView() ]);
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
