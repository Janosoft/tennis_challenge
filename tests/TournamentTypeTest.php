<?php

namespace App\Tests;

use App\Entity\TournamentType;
use PHPUnit\Framework\TestCase;

class TournamentTypeTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testATournamentTypeCanBeCreated()
    {
        $tournament_type = new TournamentType("masculino", ['Strength', 'speed', 'cosaloca']);
        dump($tournament_type);
    }
}
