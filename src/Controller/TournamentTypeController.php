<?php

namespace App\Controller;

use App\Entity\TournamentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tournament_type', name: 'tournament_type_')]
class TournamentTypeController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em= $em;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $tournament_types= $this->em->getRepository(TournamentType::class)->findAll();
        return $this->render('tournament_type/index.html.twig', [
            'controller_name' => 'TournamentTypeController',
            'tournament_types' => $tournament_types,
        ]);
    }

    #[Route('/{type}', name: 'show')]
    public function show($type): Response
    {
        //TODO hacer correctamente. Esto es una prueba
        // Mostrar todos los torneos que sean de $type

        $tournament_type = new TournamentType("masculino", ['Strength', 'speed', 'cosaloca']);
        return new Response($tournament_type->toJSON());
        /*
        $tournament_types= $this->em->getRepository(TournamentType::class)->findAll();
        return $this->render('tournament_type/index.html.twig', [
            'controller_name' => 'TournamentTypeController',
            'tournament_types' => $tournament_types,
        ]);
        */
    }

    
}
