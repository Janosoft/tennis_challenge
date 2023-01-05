<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Stage;
use App\Entity\Tournament;
use App\Entity\TournamentType;
use App\Form\TournamentTypeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'apihomepage', methods: ["GET"])]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    #[Route('/tournament_type', name: 'tournament_type_index', methods: ["GET"])]
    public function tournament_type_index(): JsonResponse
    {
        $tournament_types = $this->em->getRepository(TournamentType::class)->findAll();
        $data = [];
        foreach ($tournament_types as $tournament_type) {
            array_push($data, $tournament_type->toArray());
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/tournament_type/{title}', name: 'tournament_type_show', methods: ["GET"])]
    public function tournament_type_show(string $title): JsonResponse
    {
        $tournaments = $this->em->getRepository(Tournament::class)->findByType($title);
        $data = [];
        foreach ($tournaments as $tournament) {
            array_push($data, $tournament->toArray());
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/tournament', name: 'tournament_index', methods: ["GET"])]
    public function tournament_index(): JsonResponse
    {
        $tournaments = $this->em->getRepository(Tournament::class)->findAll();
        $data = [];
        foreach ($tournaments as $tournament) {
            array_push($data, $tournament->toArray());
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/tournament', name: 'tournament_create', methods: ["POST"])]
    public function tournament_create(Request $request): Response
    {
        $json= $request->getContent();
        if (empty($json)) return $this->json('Parameter json required. Send through Request Body', 400);
        $array= json_decode($json,true);
        if (empty($array['date'])) return $this->json('{date : value } required. Send inside json parameter', 400);
        if (empty($array['tournament_type'])) return $this->json('{tournament_type : value} required. Send inside json parameter', 400);
        if (empty($array['players'])) return $this->json('{players: value} required. Send inside json parameter', 400);
        
        $tournament = new Tournament();
        $tournament->setJson($json);
        $tournament->playJsonTournament();
        $this->em->persist($tournament);
        $this->em->flush();
        return $this->json('Created new tournament successfully with id ' . $tournament->getId());
    }

    #[Route('/tournament/{date}', name: 'tournament_show', methods: ["GET"])]
    public function tournament_show(string $date): JsonResponse
    {        
        $tournaments = $this->em->getRepository(Tournament::class)->findByDate($date);
        $data = [];
        foreach ($tournaments as $tournament) {
            array_push($data, $tournament->toArray());
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/stage', name: 'stage_index', methods: ["GET"])]
    public function stage_index(): JsonResponse
    {
        $stages = $this->em->getRepository(Player::class)->findAll();
        $data = [];
        foreach ($stages as $stage) {
            array_push($data, $stage->toArray());
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/stage/{id}', name: 'stage_show', methods: ["GET"])]
    public function stage_show(Stage $stage): JsonResponse
    {
        $data = $stage->toArray();
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/game', name: 'game_index', methods: ["GET"])]
    public function game_index(): JsonResponse
    {
        $games = $this->em->getRepository(Game::class)->findAll();
        $data = [];
        foreach ($games as $game) {
            array_push($data, $game->toArray());
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/game/{id}', name: 'game_show', methods: ["GET"])]
    public function game_show(Game $game): JsonResponse
    {
        $data = $game->toArray();
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/player', name: 'player_index', methods: ["GET"])]
    public function player_index(): JsonResponse
    {
        $players = $this->em->getRepository(Player::class)->findAll();
        $data = [];
        foreach ($players as $player) {
            array_push($data, $player->toArray());
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/player/{id}', name: 'player_show', methods: ["GET"])]
    public function player_show(Player $player): JsonResponse
    {
        $data = $player->toArray();
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
