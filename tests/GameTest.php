<?php

namespace App\Tests;

use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Stage;
use App\Entity\Tournament;
use App\Entity\TournamentType;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testAGameCanBeCreated(): void
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $player1 = new Player("Jano", 80, 80, 80);
        $player2 = new Player("Colo", 80, 80, 80);
        $game = new Game($player1, $player2, $stage);
        $this->assertNotEmpty($game);
        $this->assertIsObject($game);
    }

    public function testAGameCanBeShownAsJSON(): void
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $player1 = new Player("Jano", 80, 80, 80);
        $player2 = new Player("Colo", 80, 80, 80);
        $game = new Game($player1, $player2, $stage);
        $json = $game->toJSON();
        $this->assertNotEmpty($json);
        $this->assertIsString($json);
    }

    public function testAGameCanBePlayed()
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $player1 = new Player("Jano", 80, 80, 80);
        $player2 = new Player("Colo", 80, 80, 80);
        $game = new Game($player1, $player2, $stage);
        $winner = $game->playGame();
        $this->assertNotEmpty($winner);
        $this->assertIsObject($winner);
    }

    public function testAGameCantBePlayedWithSamePlayer()
    {
        $this->expectException(InvalidArgumentException::class);
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $player1 = new Player("Jano", 80, 80, 80);
        $game = new Game($player1, $player1, $stage);
        $game->playGame();
    }

    public function testAGameCantHaveLuckyWrongLimit(): void
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $player1 = new Player("Jano", 80, 80, 80);
        $player2 = new Player("Colo", 80, 80, 80);

        $game1 = new Game($player1, $player2, $stage);
        $game1->setLucky(-10);
        $this->assertGreaterThanOrEqual(0, $game1->getLucky());

        $game2 = new Game($player1, $player2, $stage);
        $game2->setLucky(1000);
        $this->assertLessThanOrEqual(10, $game2->getLucky());
    }

    public function testAGameCantHaveLosersWinning()
    {
        $tournament_type = new TournamentType("masculino", ['strength', 'speed']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $stage = new Stage(1, $tournament);
        $player1 = new Player("Winner", 100, 100, 100);
        $player2 = new Player("Loser", 0, 0, 0);
        $game = new Game($player1, $player2, $stage);
        $winner = $game->playGame();
        $this->assertNotEmpty($winner);
        $this->assertIsObject($winner);
        $this->assertStringContainsString("Winner",$winner->getName());
    }
}
