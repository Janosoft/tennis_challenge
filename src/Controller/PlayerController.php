<?php

namespace App\Controller;

use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/player', name: 'player_')]
class PlayerController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'index', methods: ["GET"])]
    public function index(): Response
    {
        $players = $this->em->getRepository(Player::class)->findAll();
        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
            'players' => $players,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ["GET"])]
    public function show(Player $player): Response
    {
        $player->getLocalgames();
        $player->getAwaygames();

        return $this->render('player/show.html.twig', [
            'controller_name' => 'PlayerController',
            'player' => $player,
        ]);
    }
    
}
