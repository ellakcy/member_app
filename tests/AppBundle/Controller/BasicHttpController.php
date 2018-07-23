<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class BasicHttpController extends WebTestCase
{
    protected $entityManager=null;

    protected $client=null;

    protected $container=null;

    protected $router=null;

    public function setUp()
    {
      $this->client = static::createClient();
      $this->container = $this->client->getContainer();

      $doctrine = $this->container->get('doctrine');
      $this->entityManager=$doctrine->getManager();

      $this->router=$this->client->getContainer()->get('router');
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
    * @param username String the user's username.
    * @param password String the user's password.
    * @param roles Array The user's roles.
    */
    protected function login(string $username,string $password, array $roles=[])
    {
      $client=$this->client;

      // The page where the Login Page form is getting loaded
      $loginPageUrl=$this->router->getRouteCollection()->get('fos_user_security_login')->getPath();
      $crawler=$this->client->request('GET',$loginPageUrl);

      $loginFormUrl=$this->router->getRouteCollection()->get('fos_user_security_check')->getPath();
      $form=$crawler->filter("form[action=\"$loginFormUrl\"]");
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
