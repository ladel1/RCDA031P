<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }
    #[Route('/a-propos', name: 'app_about_us')]
    public function aboutUs(): Response
    {
        $filename = $this->getParameter('kernel.project_dir')."\\data\\team.json";
        $json = file_get_contents($filename);
        $json_data =  json_decode($json,true); 
        return $this->render('main/about-us.html.twig',["team"=>$json_data]);
    }
}
