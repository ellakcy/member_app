<?php
namespace Tests\AppBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\ContactEmail;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Tools\SchemaTool;
Use Doctrine\Common\DataFixtures\Purger\ORMPurger;


use AppBundle\DataFixtures\ContactEmailDataFixture;

class ContactEmailTest extends KernelTestCase
{
  /**
    * @var \Doctrine\ORM\EntityManager
    */
   private $entityManager;

   /**
    * {@inheritDoc}
    */
   protected function setUp()
   {
       $kernel = self::bootKernel();

       $this->entityManager = $kernel->getContainer()
           ->get('doctrine')
           ->getManager();

       //In case leftover entries exist
       $schemaTool = new SchemaTool($this->entityManager);
       $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

       // Drop and recreate tables for all entities
       $schemaTool->dropSchema($metadata);
       $schemaTool->createSchema($metadata);
   }

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
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $purger = new ORMPurger($this->entityManager);
        $purger->purge();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}
