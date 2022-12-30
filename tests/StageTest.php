<?php

namespace App\Tests;

use App\Entity\Stage;
use App\Entity\Tournament;
use App\Entity\TournamentType;
use PHPUnit\Framework\TestCase;

class StageTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testAStageCanBeCreated()
    {
        $tournament_type = new TournamentType("masculino", ['Strength', 'speed', 'cosaloca']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $tournament_type->addTournament($tournament);
        $stage = new Stage(1, $tournament);
        $tournament->addStage($stage);
        dump($stage);
    }
}
