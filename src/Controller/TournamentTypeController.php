<?php

namespace App\Controller;

use App\Entity\TournamentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournamentTypeController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em= $em;
    }

    #[Route('/tournament_type', name: 'app_tournament_type')]
    public function index(): Response
    {
        $tournament_types= $this->em->getRepository(TournamentType::class)->findAll();
        return $this->render('tournament_type/index.html.twig', [
            'controller_name' => 'TournamentTypeController',
            'tournament_types' => $tournament_types,
        ]);
    }
}
