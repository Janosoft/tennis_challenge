<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Entity\TournamentType;
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

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        //FIXME no fuciona la vista
        //$tournaments = $this->em->getRepository(Tournament::class)->findAll();
        $tournaments= "";
        return $this->render('tournament/index.html.twig', [
            'controller_name' => 'TournamentController',
            'tournaments' => $tournaments,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $tournament= new Tournament();
        $form= $this->createForm(type:TournamentFormType::class, data: $tournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $tournament->playJsonTournament();
            $this->em->persist($tournament);
            $this->em->flush();
            return $this->redirectToRoute(route: 'tournament_index');
        }        
        return $this->render('tournament/create.html.twig',['form' => $form]);

    }

    #[Route('/{date}', name: 'show')]
    public function show($date): Response
    {
        //TODO hacer correctamente. Esto es una prueba
        //mostrar todos los torneos de la fecha
        $tournament_type = new TournamentType("masculino", ['Strength', 'speed', 'cosaloca']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $tournament_type->addTournament($tournament);
        
        return new Response($tournament->toJSON());


        /*
        $tournaments = $this->em->getRepository(Tournament::class)->findAll();
        return $this->render('tournament/index.html.twig', [
            'controller_name' => 'TournamentController',
            'tournaments' => $tournaments,
        ]);
        */
    }

}
