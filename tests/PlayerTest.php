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
        $player= new Player("","","","3");
        dump($player);
    }
}
