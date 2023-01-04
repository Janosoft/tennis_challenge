<?php

namespace App\Tests;

use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Stage;
use App\Entity\Tournament;
use App\Entity\TournamentType;
use PHPUnit\Framework\TestCase;

class StageTest extends TestCase
{
    public function testAStageCanBeCreated(): void
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $this->assertNotEmpty($stage);
        $this->assertIsObject($stage);
    }

    public function testAStageCanBeShownAsJSON(): void
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $player1 = new Player("Jano", 80, 80, 80);
        $player2 = new Player("Colo", 80, 80, 80);
        new Game($player1, $player2, $stage);
        $json = $stage->toJSON();
        $this->assertNotEmpty($json);
        $this->assertIsString($json);
    }

    public function testAStageCantHaveInvalidSequence(): void
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(-100, $tournament);
        $this->assertGreaterThanOrEqual(0, $stage->getSequence());
    }

    public function testAStageCanBePlayed(): void
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $player1 = new Player("Jano", 80, 80, 80);
        $player2 = new Player("Colo", 80, 80, 80);
        $player3 = new Player("Pepe", 80, 80, 80);
        $player4 = new Player("Moncho", 80, 80, 80);
        new Game($player1, $player2, $stage);
        new Game($player3, $player4, $stage);
        $winners = $stage->playStage();
        $this->assertNotEmpty($winners);
        $this->assertIsArray($winners);
    }
}
