<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        //TODO pasar última fecha de torneo y ultimo tipo de torneo para mostrar como ejemplo
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
