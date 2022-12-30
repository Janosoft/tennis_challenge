<?php

namespace App\Tests;

use App\Entity\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testAPlayerCanBeCreated()
    {
        $player = new Player("", 1, -1, 100);
        dump($player);
    }

    public function testAPlayerCanBeCreatedFromJSON()
    {
        $json = '{"name": "jano","strength": 80,"speed": 50,"reaction": 456}';
        $player = Player::fromJSON($json);
        dump($player);
    }

    public function testAPlayerCanBeShownAsJSON()
    {
        $player = new Player("Jano", 80, 90, 100);
        dump($player->toJSON());
    }
}
