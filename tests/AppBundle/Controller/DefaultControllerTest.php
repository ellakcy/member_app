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
        parent::setUp();
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
        $crawler = $client->request('GET', '/');
        $response=$client->getResponse();
        $this->assertTrue($client->getResponse()->isRedirect());
        $this->assertEquals($this->router->getRouteCollection()->get('fos_user_security_login')->getPath(),$response->headers->get('Location'));
        $client->followRedirect();
    }

    /**
    * Test if Login Page works as it should
    */
    public function testLogin()
    {
        $this->login('jdoe','simplepasswd');
    }
}
