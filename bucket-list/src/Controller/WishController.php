<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
