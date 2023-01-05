<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Form\TournamentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tournament', name: 'tournament_')]
class TournamentController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'index', methods: ["GET"])]
    public function index(): Response
    {
        $tournaments = $this->em->getRepository(Tournament::class)->findAll();
        return $this->render('tournament/index.html.twig', [
            'tournaments' => $tournaments,
        ]);
    }

    #[Route('/create', name: 'create', methods: ["GET", "POST"])]
    public function create(Request $request): Response
    {
        $tournament = new Tournament();
        $form = $this->createForm(type: TournamentFormType::class, data: $tournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tournament->playJsonTournament();
            $this->em->persist($tournament);
            $this->em->flush();
            return $this->redirectToRoute(route: 'tournament_index');
        }
        return $this->render('tournament/create.html.twig', ['form' => $form]);
    }

    #[Route('/{date}', name: 'show', methods: ["GET"])]
    public function show($date): Response
    {
        $tournaments = $this->em->getRepository(Tournament::class)->findByDate($date);
        return $this->render('tournament/show.html.twig', [
            'tournaments' => $tournaments,
        ]);
    }
}
