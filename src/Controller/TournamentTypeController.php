<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournamentTypeController extends AbstractController
{
    #[Route('/tournament/type', name: 'app_tournament_type')]
    public function index(): Response
    {
        return $this->render('tournament_type/index.html.twig', [
            'controller_name' => 'TournamentTypeController',
        ]);
    }
}
