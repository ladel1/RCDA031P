<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'app_wish')]
class WishController extends AbstractController
{
    #[Route('/', name: '_list')]
    public function list(WishRepository $repo): Response
    {
        return $this->render('wish/index.html.twig',[
            "wishes"=>$repo->findBy(["isPublished"=>True],["dateCreated"=>"DESC"])
        ]);
    }

    #[Route('/ajouter', name: '_add')]
    public function add(Request $request,EntityManagerInterface $em):Response{

        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class,$wish);

        $wishForm->handleRequest($request);
        if($wishForm->isSubmitted() && $wishForm->isValid()){
            $wish->setIsPublished(True);
            $wish->setDateCreated(new \DateTime());
            $em->persist($wish);
            $em->flush();
            $this->addFlash("success","Wish créé");
            return $this->redirectToRoute("app_wish_detail",["id"=>$wish->getId()]);
        }

        return $this->render("wish/add.html.twig",["wishForm"=>$wishForm->createView()]);
    }

    #[Route('/detail/{id}', name: '_detail')]
    public function detail(Wish $wish): Response
    {
        if(!$wish->isIsPublished()){
            throw $this->createNotFoundException('Not Found');
        }
        return $this->render('wish/detail.html.twig',compact("wish"));
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function delete(Wish $wish,EntityManagerInterface $em): Response
    {
        // sans validation !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $em->remove($wish);
        $em->flush();
        return $this->redirectToRoute("app_wish_list");
    }
}
