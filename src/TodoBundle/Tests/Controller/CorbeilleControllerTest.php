<?php

namespace TodoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CorbeilleControllerTest extends WebTestCase
{
    public function testCorbeille()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/corbeille');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/supprimer-tache-definitivement/{idtache}');
    }

}
