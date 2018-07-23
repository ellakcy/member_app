<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class BasicHttpController extends WebTestCase
{
    protected $entityManager=null;

    protected $client=null;

    protected $container=null;

    /**
    * {@inheritdoc}
    */
    public function __construct()
    {
        parent::__construct();

        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $doctrine = $this->container->get('doctrine');
        $this->entityManager=$doctrine->getManager();
    }

    /**
    * Remove all entities from the database
    */
    protected function truncateEntities()
    {
        $purger = new ORMPurger($this->entityManager);
        $purger->purge();
    }


    /**
    * {@inheritdoc}
    */
    public function tearDown()
    {
        $this->truncateEntities();
    }

    /**
    * @param username String the user's username
    * @param passwoρd String the user's password
    */
    protected function checkPanelAfterSucessfullLogin($crawler,string $username,string $password)
    {
        //Submitting the form
        $form=$crawler->selectButton('#_submit')->form();
        $form['_username']=$username;
        $form['_password']=$password;

        $crawler=$crawler->submit($form);
        $response=$client->getResponse();
        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();

        //Checking header
        $headerDom=$crawler->filter('header')->childen()->filter('nav.navbar')->children();
        $this->assertCount(1,$headerDom->find('a.navbar-brand')); //homepage link
        $this->assertCount(1,$headerDom->find('a.btn-danger')); //Logout button
    }
}
