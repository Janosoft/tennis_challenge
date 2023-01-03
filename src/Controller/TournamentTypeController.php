<?php

namespace App\Controller;

use App\Entity\TournamentType;
use App\Form\TournamentTypeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $tournament_types = $this->em->getRepository(TournamentType::class)->findAll();
        return $this->render('tournament_type/index.html.twig', [
            'controller_name' => 'TournamentTypeController',
            'tournament_types' => $tournament_types,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $tournament_type = new TournamentType();
        $form = $this->createForm(type: TournamentTypeFormType::class, data: $tournament_type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($tournament_type);
            $this->em->flush();
            return $this->redirectToRoute(route: 'tournament_type_index');
        }

        return $this->render('tournament_type/create.html.twig', ['form' => $form]);
    }

    #[Route('/{title}', name: 'show')]
    public function show($title): Response
    {
        $tournament_types = $this->em->getRepository(TournamentType::class)->findByTitle($title);
        return $this->render('tournament_type/show.html.twig', [
            'controller_name' => 'TournamentController',
            'tournament_types' => $tournament_types,
        ]);
    }
}
