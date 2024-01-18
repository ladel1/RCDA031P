<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Entity\Patient;
use App\Repository\MedecinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController{

    #[Route('/home',name:'app_home')]
    public function home(EntityManagerInterface $em): Response{

        $p = new Patient();
        $p->setEmail("bbb@aa.aa")
            ->setPassword("1231321")
            ->setNss("sdqsdq");
        $em->persist($p);
        $em->flush();


        return $this->render("main/home.html.twig");
    }

    #[Route('/contact',name:'app_contact')]
    public function contact(): Response{
        return $this->render("main/contact.html.twig");
    }
    
    #[Route('/blog',name:'app_blog')]
    public function blog(): Response{
        return $this->render("main/blog.html.twig");
    }    

}