<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController{

    #[Route('/home',name:'app_home')]
    public function home(): Response{
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