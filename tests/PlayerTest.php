<?php

namespace App\Tests;

use App\Entity\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testAPlayerCanBeCreated(): void
    {
        $player = new Player("Jano", 80, 80, 80);
        $this->assertNotEmpty($player);
        $this->assertIsObject($player);
    }

    public function testAPlayerCanBeCreatedFromJSON(): void
    {
        $json = '{"name": "jano","strength": 80,"speed": 50,"reaction": 456}';
        $player = Player::fromJSON($json);
        $this->assertNotEmpty($player);
        $this->assertIsObject($player);
    }

    public function testAPlayerCanBeShownAsJSON(): void
    {
        $player = new Player("Jano", 80, 90, 100);
        $json = $player->toJSON();
        $this->assertNotEmpty($json);
        $this->assertIsString($json);
    }

    public function testAPlayerCantHaveEmptyName(): void
    {
        $player = new Player("", 80, 80, 80);
        $this->assertIsObject($player);
        $this->assertNotEmpty($player->getName());
        $this->assertIsString($player->getName());
    }

    public function testAPlayerCantHaveSkillsWrongLimit(): void
    {
        $player1 = new Player("Weak", -10, -10, -10);
        $this->assertGreaterThanOrEqual(0, $player1->getStrength());
        $this->assertGreaterThanOrEqual(0, $player1->getSpeed());
        $this->assertGreaterThanOrEqual(0, $player1->getReaction());

        $player2 = new Player("Strong", 1000, 1000, 1000);
        $this->assertLessThanOrEqual(100, $player2->getStrength());
        $this->assertLessThanOrEqual(100, $player2->getSpeed());
        $this->assertLessThanOrEqual(100, $player2->getReaction());
    }
}
