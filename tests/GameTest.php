<?php

namespace App\Tests;

use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Stage;
use App\Entity\Tournament;
use App\Entity\TournamentType;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testAGameCanBeCreated()
    {
        $tournament_type = new TournamentType("masculino", ['Strength', 'speed', 'cosaloca']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $tournament->addStage($stage);
        $player1 = new Player("Jano", 80, 80, 80);
        $player2 = new Player("Colo", 80, 80, 80);
        $game = new Game($player1, $player2, $stage);
        $player1->addLocalgame($game);
        $player2->addAwaygame($game);
        //dump($game);

        //TODO test rápido de jugar un juego (quitar de acá)
        $winner = $game->playGame(true);
        dump("Winner: " . $winner->getName());
    }
}
