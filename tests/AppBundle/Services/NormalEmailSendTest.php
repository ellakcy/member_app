<?php
namespace Tests\AppBundle\Services;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
* @testype functional
*/
class ContactEmailSendTest extends KernelTestCase
{

   /**
   * @var AppBundle\Services\NormalEmailSend
   */
   private $service;

    /**
    * {@inheritDoc}
    */
     protected function setUp()
     {
         $kernel = self::bootKernel();
         $this->service = $kernel->getContainer()->get(AppBundle\Services\NormalEmailSend::class);
     }

     public function sendEmailTest()
     {

     }

    /**
    * {@inheritDoc}
    */
    public function tearDown()
    {
        $spoolDir = $this->getSpoolDir();
        $filesystem = new Filesystem();
        $filesystem->remove($spoolDir);
    }

    /**
    * @return string
    */
    private function getSpoolDir()
    {
      return $this->kernel->getContainer()->getParameter('swiftmailer.spool.default.file.path');
    }

}
