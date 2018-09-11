<?php
namespace Tests\AppBundle\Services;

use PHPUnit\Framework\TestCase;
use \AppBundle\Services\CapthaServiceAdapter;
use Symfony\Component\HttpFoundation\Session\Session;


class CapthcaServiceTest extends TestCase
{

  private function getServiceForBuild()
  {
    $mock=$this->createMock(Session::class);
    return new CapthaServiceAdapter($mock);
  }

  public function testBuildInline()
  {
    $service=$this->getServiceForBuild();
    $capthaValue=$service->build('somevalue',CapthaServiceAdapter::IMAGE_INLINE);
    $this->assertRegExp('/^data:image\/jpeg;base64,\s*[A-Za-z0-9\+\/]+=*$/i',$capthaValue);
  }

  public function testBuildImage()
  {
    // $service=$this->getServiceForBuild();
    // $capthaValue=$service->build('somevalue',CapthaServiceAdapter::IMAGE_NORMAL);
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  public function testBuildWrongParam()
  {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

  private function mockSessionForVerify()
  {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );

  }

  public function testVerifySucess()
  {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );

  }

  public function testVerifyFail()
  {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }
}
