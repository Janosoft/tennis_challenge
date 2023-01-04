<?php

namespace App\Tests;

use App\Entity\TournamentType;
use PHPUnit\Framework\TestCase;

class TournamentTypeTest extends TestCase
{
    public function testATournamentTypeCanBeCreated(): void
    {
        $tournament_type = new TournamentType("masculino", ['Strength', 'speed', 'cosaloca']);
        $this->assertNotEmpty($tournament_type);
        $this->assertIsObject($tournament_type);
    }

    public function testTournamentTypeCanBeCreatedFromJSON(): void
    {
        $json = '{"title": "masculino","skills": ["Strength","speed"]}';
        $tournament_type = TournamentType::fromJSON($json);
        $this->assertNotEmpty($tournament_type);
        $this->assertIsObject($tournament_type);
    }

    public function testATournamentTypeCanBeShownAsJSON(): void
    {
        $tournament_type = new TournamentType("masculino", ['Strength', 'speed', 'cosaloca']);
        $json = $tournament_type->toJSON();
        $this->assertNotEmpty($json);
        $this->assertIsString($json);
    }

    public function testATournamentTypeCantHaveEmptyTitle(): void
    {
        $tournament_type = new TournamentType("", ['Strength', 'speed', 'cosaloca']);
        $this->assertIsObject($tournament_type);
        $this->assertNotEmpty($tournament_type->getTitle());
        $this->assertIsString($tournament_type->getTitle());
    }

    public function testATournamentTypeCantHaveEmptySkills(): void
    {
        $tournament_type = new TournamentType("masculino", []);
        $this->assertIsObject($tournament_type);
        $this->assertNotEmpty($tournament_type->getSkills());
        $this->assertIsArray($tournament_type->getSkills());
    }

    public function testATournamentTypeCantHaveInvalidSkills(): void
    {
        $tournament_type = new TournamentType("masculino", ['cosainvalida']);
        $this->assertIsObject($tournament_type);
        $this->assertNotEmpty($tournament_type->getSkills());
        $this->assertIsArray($tournament_type->getSkills());
    }
}
