<?php

namespace App\Tests;

use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Stage;
use App\Entity\Tournament;
use App\Entity\TournamentType;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class TournamentTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testATournamentCanBeCreated()
    {
        $tournament_type = new TournamentType("masculino", ['Strength', 'speed', 'cosaloca']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        dump($tournament);
    }

    public function testATournamentCanBeShownAsJSON()
    {
        $tournament_type = new TournamentType("masculino", ['Strength', 'speed', 'cosaloca']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $player1 = new Player("Jano", 80, 80, 80);
        $player2 = new Player("Colo", 80, 80, 80);
        $game = new Game($player1, $player2, $stage);
        dump($tournament->toJSON());
    }

    public function testATournamentCanBePlayed()
    {
        // CREAR TORNEO
        $tournament_type = new TournamentType("masculino", ['Strength', 'speed', 'cosaloca']);
        $tournament = new Tournament("2010-01-28", $tournament_type);

        // ARMAR LISTA DE JUGADORES        
        $players = array();
        array_push($players, new Player("Jano", 80, 80, 80));
        array_push($players, new Player("Andy", 80, 80, 80));
        array_push($players, new Player("Colo", 80, 80, 80));
        array_push($players, new Player("Fede", 80, 80, 80));
        array_push($players, new Player("Nacho", 80, 80, 80));
        array_push($players, new Player("Frumento", 80, 80, 80));
        array_push($players, new Player("Moncho", 80, 80, 80));
        array_push($players, new Player("Sergio", 80, 80, 80));
        shuffle($players);

        //VERIFICAR CANTIDAD DE JUGADORES
        if (!Tournament::validAmountOfPlayers(count($players))) die("La cantidad de jugadores no es potencia de 2");

        $iteration = 0;
        while (count($players)!=1) {        
            // CREAR STAGE
            $iteration++;
            $stage = new Stage($iteration, $tournament);
            while (!empty($players)) {
                new Game(array_pop($players), array_pop($players), $stage);
            }
            $players= $stage->playStage()->toArray();
        }

        // MOSTRAR GANADOR
        $ganador= array_pop($players);
        dump ("EL GANADOR FUE: {$ganador->getName()}");
        
    }
}
