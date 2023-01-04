<?php

namespace App\Tests;

use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Stage;
use App\Entity\Tournament;
use App\Entity\TournamentType;
use PHPUnit\Framework\TestCase;

class TournamentTest extends TestCase
{

    public function testATournamentCanBeCreated(): void
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $this->assertNotEmpty($tournament);
        $this->assertIsObject($tournament);
    }

    public function testATournamentCanBeShownAsJSON(): void
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $player1 = new Player("Jano", 80, 80, 80);
        $player2 = new Player("Colo", 80, 80, 80);
        new Game($player1, $player2, $stage);
        $json = $tournament->toJSON();
        $this->assertNotEmpty($json);
        $this->assertIsString($json);
    }

    public function testATournamentCantHaveInvalidDate(): void
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("", $tournament_type);
        $this->assertNotEmpty($tournament->getDate());
    }

    public function testATournamentCanBePlayed(): void
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $player1 = new Player("Jano", 80, 80, 80);
        $player2 = new Player("Colo", 80, 80, 80);
        $player3 = new Player("Pepe", 80, 80, 80);
        $player4 = new Player("Moncho", 80, 80, 80);
        $players = [$player1, $player2, $player3, $player4];
        $tournament->playTournament($players);
        $this->assertNotEmpty($tournament->getWinner());
        $this->assertIsString($tournament->getWinner());
    }
    
    public function testATournamentCantHaveLosersWinning(): void
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $player1 = new Player("Winner", 100, 100, 100);
        $player2 = new Player("Loser 1", 0, 0, 0);
        $player3 = new Player("Loser 2", 0, 0, 0);
        $player4 = new Player("Loser 3", 0, 0, 0);
        $players = [$player1, $player2, $player3, $player4];
        $tournament->playTournament($players);
        $this->assertNotEmpty($tournament->getWinner());
        $this->assertIsString($tournament->getWinner());
        $this->assertStringContainsString("Winner",$tournament->getWinner());
    }


}
