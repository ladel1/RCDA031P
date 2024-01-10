<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {   
        dump($this->getParameter('kernel.project_dir')."\\data\\team.json");
        $name = "Eric Maisel";
        $age = 20;
        // compact("name") <====> 
        //['name'=>"Eric Maisel"]
        return $this->render('main/index.html.twig', 
        compact("name","age"));
    }
}
