<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request,EntityManagerInterface $em): Response
    {
        /**
         * @var User
         */
        $user = $this->getUser();
        $client = $user->getClient();
        if(!$client){
            $client = new Client();
            $client->setUser($user);
        }
        $form = $this->createForm(ClientType::class,$client);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($client);
            $em->flush();
            $this->addFlash("success","Client modifié!");
            return $this->redirectToRoute("app_profile");
        }

        return $this->render('profile/index.html.twig', [
            "form"=>$form->createView()
        ]);
    }
}
