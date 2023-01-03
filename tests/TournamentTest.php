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

        $tournament->playTournament($players);
        dump("EL GANADOR FUE: {$tournament->getWinner()}");
        dump($tournament->toJSON());
    }
}
