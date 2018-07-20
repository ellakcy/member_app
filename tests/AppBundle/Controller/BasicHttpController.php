<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicHttpController extends WebTestCase
{

    /**
    * @param username String the user's username
    * @param passwod String the user's password
    */
    protected function checkPanelAfterSucessfullLogin($crawler,$username,$password)
    {
        //Submitting the form
        $form=$crawler->selectButton('_submit')->form();
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
