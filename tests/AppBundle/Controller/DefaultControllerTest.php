<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $response=$client->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/login',$response->headers->get('Location'));
    }
}
