<?php

namespace App\Controller;

use App\Entity\Stage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StageController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/stage', name: 'app_stage')]
    public function index(): Response
    {
        $stages = $this->em->getRepository(Stage::class)->findAll();
        return $this->render('stage/index.html.twig', [
            'controller_name' => 'StageController',
            'stages' => $stages,
        ]);
    }
}
