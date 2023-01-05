<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    public function testIndexCanBeShowed(): void
    {
        $client = static::createClient([], ['HTTP_HOST' => 'localhost:8000','HTTPS' => true]);
        $client->followRedirects(true);
        $client->request('GET', '/player');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Listado de Jugadores');
    }
}
