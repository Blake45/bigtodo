<?php

namespace TodoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EtatControllerTest extends WebTestCase
{
    public function testCreateetat()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'creation-etat');
    }

}
