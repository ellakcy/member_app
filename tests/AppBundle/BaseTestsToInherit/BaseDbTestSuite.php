<?php
namespace Tests\AppBundle\BaseTestsToInherit;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\Tools\SchemaTool;
Use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class BaseDbTestSuite extends KernelTestCase
{
  /**
    * @var \Doctrine\ORM\EntityManager
    */
   protected $entityManager;

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
