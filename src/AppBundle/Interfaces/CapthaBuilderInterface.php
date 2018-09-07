<?php
namespace AppBundle\Interfaces;

interface CapthaBuilderInterface
{

  /**
  * Generates the Captha
  * @param String $identifier An identifier to distinguish the Captha value
  * @param String|Integer $type What type of image will get returned
  * @return Mixed
  */
  public function build($identifier,$type);

  /**
  * Verify the Captcha $identifier having $value
  * @param String $identifier An identifier to distinguish the Captha value
  * @param String $value the Captha Value to verify
  * @return Boolean
  */
  public function verify($identifier,$value);

}
