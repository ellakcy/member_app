<?php
namespace Tests\AppBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\ContactEmail;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

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
       $this->entityManager->createQuery('DELETE AppBundle:ContactEmail c')->execute();
   }


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
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->entityManager->createQuery('DELETE AppBundle:ContactEmail c')->execute();
        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}
