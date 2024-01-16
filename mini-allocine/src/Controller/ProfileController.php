<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\ProfileType;
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
        $profile = $user->getProfile();
        if(!$profile){
            $profile = new Profile();
        }
        $profileForm = $this->createForm(ProfileType::class,$profile);
        $profileForm->handleRequest($request);

        if($profileForm->isSubmitted() && $profileForm->isValid()){
            $user->setProfile($profile);
            $em->flush();

            $this->addFlash("success","Profil modifié");
            return $this->redirectToRoute("app_profile");
        }

        return $this->render('profile/index.html.twig', [
            'profileForm' => $profileForm->createView(),
        ]);
    }
}
