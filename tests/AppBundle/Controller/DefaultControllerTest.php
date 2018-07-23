<?php

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\Controller\BasicHttpController;
use AppBundle\DataFixtures\Test\DummyUserFixtures;

/**
* @testtype Functional
*/
class DefaultControllerTest extends BasicHttpController
{
    /**
    * {@inheritdoc}
    */
    public function setUp()
    {
        $fixture = new DummyUserFixtures();
        $fixture->setContainer($this->container);
        $fixture->load($this->entityManager);
    }

    /**
    * Testing the Behavior when visiting the index page
    */
    public function testIndex()
    {
        $client = $this->client;
        $router=$client->getContainer()->get('router');
        $crawler = $client->request('GET', '/');
        $response=$client->getResponse();
        $this->assertTrue($client->getResponse()->isRedirect());
        $this->assertEquals($router->getRouteCollection()->get('fos_user_security_login')->getPath(),$response->headers->get('Location'));

        //@todo Create Dummy Users
        // $this->checkPanelAfterSucessfullLogin($crawler);
    }
}
