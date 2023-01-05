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
        $this->em = $em;
    }

    #[Route('/', name: 'index', methods: ["GET"])]
    public function index(): Response
    {
        $tournament_types = $this->em->getRepository(TournamentType::class)->findAll();
        return $this->render('tournament_type/index.html.twig', [
            'controller_name' => 'TournamentTypeController',
            'tournament_types' => $tournament_types,
        ]);
    }
    
    #[Route('/{title}', name: 'show', methods: ["GET"])]
    public function show($title): Response
    {
        $tournament_types = $this->em->getRepository(TournamentType::class)->findByTitle($title);
        return $this->render('tournament_type/show.html.twig', [
            'controller_name' => 'TournamentController',
            'tournament_types' => $tournament_types,
        ]);
    }

}
