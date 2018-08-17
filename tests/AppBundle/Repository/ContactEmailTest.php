<?php
namespace Tests\AppBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

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
   }


   public function testInsert()
   {
     $email="jdoe@example.com";
     /**
     * @var Appbundle\Repository\ContactEmailRepository
     */
     $repository=$this->entityManager->getRepository(ContactEmail::class);

     $contactEmailEntiry=$repository->addEmail($email);
     $emailSearched=$repository->findByEmail($email);
     
     $this->assertEquals($email,$emailSearched);
   }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}
