<?php

namespace App\DataFixtures;

use App\Entity\Player;
use App\Entity\Tournament;
use App\Entity\TournamentType;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TournamentFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        // CREAR TORNEO
        $tournament_type = new TournamentType("masculino", ['Strength', 'speed', 'cosaloca']);        
        $tournament = new Tournament($faker->date(), $tournament_type);
        
        // ARMAR LISTA DE JUGADORES        
        $players = array();
        array_push($players, new Player($faker->name(), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100)));
        array_push($players, new Player($faker->name(), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100)));
        array_push($players, new Player($faker->name(), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100)));
        array_push($players, new Player($faker->name(), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100)));
        array_push($players, new Player($faker->name(), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100)));
        array_push($players, new Player($faker->name(), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100)));
        array_push($players, new Player($faker->name(), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100)));
        array_push($players, new Player($faker->name(), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100), $faker->numberBetween(0, 100)));

        // SE JUEGA EL TORNEO
        $tournament->playTournament($players);
        
        $manager->persist($tournament_type);
        $manager->flush();
    }
}
