<?php
namespace Tests\AppBundle\Services;

use PHPUnit\Framework\TestCase;
use \AppBundle\Services\CapthaServiceAdapter;
use Symfony\Component\HttpFoundation\Session\Session;


class CapthcaServiceTest extends TestCase
{

 /**
 * Getting the image for Teststhat require to retrieve the image
 * @param Integer $type The type of the image.
 *
 * The $type parameter takes one of theese values:
 * - CapthaServiceAdapter::IMAGE_INLINE
 * - CapthaServiceAdapter::IMAGE_NORMAL
 *
 * You can place other values to check that behaves correctly on wrong inputs
 */
  private function getImageForTests($type)
  {
    $mock=$this->createMock(Session::class);
    $service=new CapthaServiceAdapter($mock);
    return $service->build('somevalue',$type);
  }

  public function testBuildInline()
  {
    $this->assertRegExp('/^data:image\/jpeg;base64,\s*[A-Za-z0-9\+\/]+=*$/i',$this->getImageForTests(CapthaServiceAdapter::IMAGE_INLINE));
  }

  public function testBuildImage()
  {
    $image=$this->getImageForTests(CapthaServiceAdapter::IMAGE_NORMAL);
    $this->assertTrue(imagecreatefromstring($image)!=FALSE);
  }

  public function testBuildWrongParam()
  {
    $this->expectException(\InvalidArgumentException::class);
    $this->getImageForTests('lalalala');
  }

  private function getServiceForCapthaVerify($returnValue='hello')
  {
    $mock=$this->createMock(Session::class);
    $mock->method('get')->will($this->returnValue($returnValue));

    return new CapthaServiceAdapter($mock);
  }

  public function testVerifySucess()
  {
    $service=$this->getServiceForCapthaVerify();
    $this->assertTrue($service->verify('identifier','hello'));
  }

  public function testVerifyFail()
  {
    $service=$this->getServiceForCapthaVerify();
    $this->assertFalse($service->verify('identifier','hentai'));
  }

  public function testEmpty()
  {
    $service=$this->getServiceForCapthaVerify(null);
    $this->assertFalse($service->verify('identifier','hentai'));
  }

}
