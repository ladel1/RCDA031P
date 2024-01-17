<?php

namespace App\Controller;

use App\Service\Operations;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculatriceController extends AbstractController
{
    #[Route('/calculatrice', name: 'app_calculatrice')]
    public function index(Request $request,Operations $operations): Response
    {

        $op1 = $request->get("op1");
        $op = $request->get("op");
        $op2 = $request->get("op2");

        $result = 0;
        if($op){            
            /**
             * function variable
             * @see https://www.php.net/manual/en/functions.variable-functions.php
             */
            $result = $operations->$op($op1,$op2);
        }

        return $this->render('calculatrice/index.html.twig', [
            'result' => $result,
        ]);
    }
}
