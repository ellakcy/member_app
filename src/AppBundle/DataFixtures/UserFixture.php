<?php
namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

 class UserFixture extends Fixture
 {

   /**
   * @var UserPasswordEncoderInterface
   */
   private $passwordEncoder=null;

   public function __construct(UserPasswordEncoderInterface $passwordEncoder)
   {
     $this->passwordEncoder=$passwordEncoder;
   }


   public function createSimpleActivatedUser(ObjectManager $manager)
   {
     $activeUser= new User('jdoe','jdoe@example.com',['ROLE_USER'],true);
     $activeUserPassword=$this->passwordEncoder->encodePassword($activeUser,'pass1234');
     $activeUser->setPassword($activeUserPassword);

     $manager->persist($activeUser);
   }

   public function createInactiveAUserWithPassword(ObjectManager $manager)
   {
     $inActiveUser= new User('jdoe_inactive','jdoeInactive@example.com',['ROLE_USER'],false);
     $activeUserPassword=$this->passwordEncoder->encodePassword($inActiveUser,'pass1234');
     $inActiveUser->setPassword($activeUserPassword);

     $manager->persist($inActiveUser);
   }

   public function createInactiveAUserWithoutPassword(ObjectManager $manager)
   {
     $inActiveUser= new User('paswordless','paswordless@example.com',['ROLE_USER'],false);
     $manager->persist($inActiveUser);
   }

   public function createAdmin(ObjectManager $manager)
   {
     $activeAdmin= new User('admin','elakcyAdmin@example.com',['ROLE_USER'],true);
     $activeUserPassword=$this->passwordEncoder->encodePassword($activeAdmin,'admin1234');
     $activeAdmin->setPassword($activeUserPassword);
     $manager->persist($activeAdmin);
   }

   public function load(ObjectManager $manager)
   {
     $this->createSimpleActivatedUser($manager);
     $this->createInactiveAUserWithPassword($manager);
     $this->createInactiveAUserWithoutPassword($manager);
     $this->createAdmin($manager);

     $manager->flush();
   }
 }
