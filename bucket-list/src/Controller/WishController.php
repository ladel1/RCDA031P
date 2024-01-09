<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'app_wish')]
class WishController extends AbstractController
{
    #[Route('/', name: '_list')]
    public function list(): Response
    {
        return $this->render('wish/index.html.twig');
    }
    #[Route('/detail', name: '_detail')]
    public function detail(): Response
    {
        return $this->render('wish/detail.html.twig');
    }
}
