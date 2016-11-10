<?php

namespace TodoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StatsControllerTest extends WebTestCase
{
    public function testEndedtask()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/endedTask');
    }

    public function testProject()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/bilan-{projet}/{id_projet}');
    }

    public function testDevelopper()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/bilan-developper/{iddev}');
    }

}
