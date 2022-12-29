<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/game', name: 'app_game')]
    public function index(): Response
    {
        $games = $this->em->getRepository(Game::class)->findAll();
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
            'games' => $games,
        ]);
    }
}
