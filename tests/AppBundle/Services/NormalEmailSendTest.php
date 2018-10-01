<?php
namespace Tests\AppBundle\Services;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use \Swift_Message;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;

use AppBundle\Services\NormalEmailSend;

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
   * @var String
   */
   private $spoolPath=null;

    /**
    * {@inheritDoc}
    */
     protected function setUp()
     {
         $kernel = self::bootKernel();
         $container = $kernel->getContainer();
         $this->service = $container->get(NormalEmailSend::class);
         $this->spoolPath = $container->getParameter('swiftmailer.spool.default.file.path');
     }

    public function testSendEmail()
    {
       $from='sender@example.com';
       $to='receiver@example.com';
       $this->service->send($from,$to,'Hello','Hello','Hello');
       $this->checkEmail();
    }

    private function checkEmail()
    {
      $spoolDir = $this->getSpoolDir();
      $filesystem = new Filesystem();

      if ($filesystem->exists($spoolDir)) {
          $finder = new Finder();
          $finder->in($spoolDir)
                 ->ignoreDotFiles(true)
                ->files();

          if(!$finder->hasResults()){
            $this->fail('No email has been sent');
          }

          $counter=0;
          foreach ($finder as $file) {
              /** @var Swift_Message $message */
              $message = unserialize(file_get_contents($file));
              $header = $message->getHeaders()->get('X-Agent');
              $this->assertEquals($header->getValue(),'ellakcy_member_app');
              $counter++;
          }

          //@todo Possibly Consinder not doing this check
          if($counter===0){
              $this->fail('No email has been sent');
          }

      } else {
        $this->fail('On test environment the emails should be spooled and not actuallt be sent');
      }
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
      return $this->spoolPath;
    }

}
