<?php
namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\ContactEmail;

class ContactEmailDataFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $emails=['jdoe@example.com','example@gmail.com','user1@example.com'];
        foreach($emails as $email){
          $emailEntityInstance=new ContactEmail();
          $emailEntityInstance->setEmail($email);

          $manager->persist($emailEntityInstance);
          $manager->flush();
        }
    }
}
