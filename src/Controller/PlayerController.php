<?php

namespace App\Controller;

use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/player', name: 'app_player')]
    public function index(): Response
    {
        $players = $this->em->getRepository(Player::class)->findAll();
        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
            'players' => $players,
        ]);
    }
}
