<?php
namespace Tests\AppBundle\Repository;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;


use AppBundle\Entity\ContactEmail;
use AppBundle\DataFixtures\ContactEmailDataFixture;
use Tests\AppBundle\BaseTestsToInherit\BaseDbTestSuite;

class ContactEmailTest extends BaseDbTestSuite
{

   /**
   * Checking whether a contact email will get Inserted
   */
   public function testInsert()
   {
     $email="jdoe@example.com";
     /**
     * @var Appbundle\Repository\ContactEmailRepository
     */
     $repository=$this->entityManager->getRepository(ContactEmail::class);

     $contactEmailEntity=$repository->addEmail($email);

     //Check if returned email in the one we inserted
     $this->assertEquals($contactEmailEntity->getEmail(),$email);

     $emailSearched=$repository->findByEmail($email);

     //Check if email has been inserted to the db
     if(empty($emailSearched)){
        $this->fail('No email has been found');
     }

     // And check if email also exists in the database as well
     $this->assertEquals($email,$emailSearched[0]->getEmail());
   }

   /**
   * Checking whether an exception will get thrown
   * When we try to insert the same entry rtwice
   */
   public function testInsertDucplicate()
   {
     $email="jdoe@example.com";

     /**
     * @var Appbundle\Repository\ContactEmailRepository
     */
     $repository=$this->entityManager->getRepository(ContactEmail::class);

     // We purpocely ingoring the returned value
     $repository->addEmail($email);

     $this->expectException(UniqueConstraintViolationException::class);
     $repository->addEmail($email);

   }

   /**
   * Testing whether a preloaded email will get deleted
   */
   public function testDeletion()
   {
     $fixture = new ContactEmailDataFixture();
     $fixture->load($this->entityManager);

     /**
     * @var Appbundle\Repository\ContactEmailRepository
     */
     $repository=$this->entityManager->getRepository(ContactEmail::class);

     $emailToDelete='jdoe@example.com';
     $repository->deleteEmail($emailToDelete);

     $emailSearched=$repository->findOneBy(['email'=>$emailToDelete]);
     $this->assertEmpty($emailSearched);
   }

   /**
   * Getting the list of the Emails as a String Array
   * and performing Common Checks
   */
   private function getEmailListAndPerformCommonChecks()
   {
     $repository=$this->entityManager->getRepository(ContactEmail::class);

     $listEmails=$repository->getEmailListInOrderToSendEmail();
     $this->assertInternalType('array',$listEmails);

     return $listEmails;
   }

   public function testGetEmailAdressList()
   {
     $fixture = new ContactEmailDataFixture();
     $fixture->load($this->entityManager);

     $listEmails=$this->getEmailListAndPerformCommonChecks();
     $arrayCount=count($listEmails);
     $this->assertGreaterThan(0,$arrayCount);
   }

   public function testIfStillReturnsEmptyArrayWhenNoListArrayExists()
   {
      $listEmails=$this->getEmailListAndPerformCommonChecks();
      $this->assertEmpty($listEmails);
   }



}
