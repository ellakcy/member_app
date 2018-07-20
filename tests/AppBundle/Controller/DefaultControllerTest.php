<?php

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\Controller\BasicHttpController;

/**
* @testtype Functional
*/
class DefaultControllerTest extends BasicHttpController
{

    // /**
    // * {@inheritdoc}
    // */
    // public function setUp()
    // {
    //     $client = static::createClient();
    //     $container = $client->getContainer();
    //     $doctrine = $container->get('doctrine');
    //     $entityManager = $doctrine->getManager();
    //
    //     $fixture = new YourFixture();
    //     $fixture->load($entityManager);
    // }
    //
    // /**
    // * {@inheritdoc}
    // */
    // public function tearDown()
    // {
    //
    // }

    public function testIndex()
    {
        $client = static::createClient();
        $router=$client->getContainer()->get('router');
        $crawler = $client->request('GET', '/');
        $response=$client->getResponse();
        $this->assertTrue($client->getResponse()->isRedirect());
        $this->assertEquals($router->getRouteCollection()->get('fos_user_security_login')->getPath(),$response->headers->get('Location'));

        //@todo Create Dummy Users
        // $this->checkPanelAfterSucessfullLogin($crawler); //How I can create some user?
    }


}
