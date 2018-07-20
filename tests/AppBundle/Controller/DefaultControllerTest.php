<?php

namespace Tests\AppBundle\Controller;


class DefaultControllerTest extends BasicHttpController
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $response=$client->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/login',$response->headers->get('Location'));

        $this->checkPanelAfterSucessfullLogin($crawler); //How I can create some user?
    }


}
