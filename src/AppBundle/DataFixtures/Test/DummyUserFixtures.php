<?php

/**
* @author Dimitrios Desyllas
* This class has been created in order to provide a way to fill dummy data
* to the database for functional tests.
*/

namespace AppBundle\DataFixtures\Test;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DummyUserFixtures extends AbstractFixture implements OrderedFixtureInterface,ContainerAwareInterface
{

    /**
    * @var ContainerInterface
    */
    private $container=null;


    /**
    * {@inheritDoc}
    */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
    * Generic function that creates a user with provided information.
    * @param $name {String} The user's name
    * @param $surname {String} The user's surname
    * @param $username {String} The user's username
    * @param $password {String} The user's password
    * @param $email {String} The user's recovery email
    * @param $role {String} The user's system role
    * @param $phone {String | null} The user's phone number
    * @param $organization {String|null} The user's organization
    * @param $occupation {String|null} The user's occupation
    *
    * @return AppBundle\Entity\User
    */
    private function createUser($name,$surname,$username,$password,$email,$role,$phone=null,$organization=null,$occupation=null)
    {
        $fosUserManager=$this->container->get('fos_user.user_manager');

        /**
        * @var AppBundle\Entity\User
        */
        $user=$fosUserManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled(true);
        $user->setRoles(array($role));

        $user->setName($name);
        $user->setSurname($surname);

        if($phone){
            $user->setPhone($phone);
        }

        if($organization){
            $user->setOrganization($organization);
        }

        if($occupation){
            $user->setOccupation($occupation);
        }

        $fosUserManager->updateUser($user, true);

        return $user;
    }

    /**
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager)
    {
        $this->createUser('John','Doe','jdoe','simplepasswd','jdoe@example.com','ROLE_USER','+3021456742324','Acme Products','Soft Engineer');
        $this->createUser('Jackie','Chan','jchan','thesimplepasswd','jackiechan@example.com','ROLE_ADMIN','+302141232324','Holywood','Actor');
        $this->createUser('Chuck','Norris','chuck_norris','unhackablepasswd','chucknorris@example.com','ROLE_SUPERADMIN',null,'Universe','Master');
    }

    public function getOrder()
    {
       return 1;
    }
}
