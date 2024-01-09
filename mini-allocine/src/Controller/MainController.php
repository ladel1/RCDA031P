<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {   
        $name = "Eric Maisel";
        $age = 20;
        // compact("name") <====> 
        //['name'=>"Eric Maisel"]
        return $this->render('main/index.html.twig', 
        compact("name","age"));
    }

    #[Route('/titres/ajouter', name: 'app_media')]
    public function addMedia(): Response
    {
        return $this->render('main/add-media.html.twig');
    }
}
