<?php
namespace AppBundle\Services;

use AppBundle\Interfaces\CapthaBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Gregwar\Captcha\CaptchaBuilder;

/**
* The following class is an adapter for Gregwar Captcha Builder
* I do not set Gregwar's Captha Builder as a Service
* Because I want to stay hidden fromt he service container.
*/
class CapthaServiceAdapter implements CapthaBuilderInterface
{

  const IMAGE_INLINE=0;
  const IMAGE_NORMAL=1;

  /**
  * @var Session;
  */
  private $session=null;

  /**
  * @var CaptchaBuilder
  */
  private $capthaBuilder=null;

  public function __construct(Session $sessionManager)
  {
    $this->session=$sessionManager;
    $this->capthaBuilder=new CaptchaBuilder();
  }

  /**
  * @inheritdoc
  * @throws \InvalidArgumentException when type is not either self::IMAGE_INLINE or self::IMAGE_NORMAL
  */
  public function build($identifier,$type)
  {
    if($type!==self::IMAGE_INLINE && $type!==self::IMAGE_NORMAL){
      throw new \InvalidArgumentException("Type should be either CapthaService::IMAGE_INLINE or CapthaService::IMAGE_NORMAL you provided the value: ".$type);
    }

    $this->capthaBuilder->build();
    $this->session->set($identifier,$this->capthaBuilder->getPhrase());

    if($type==self::IMAGE_INLINE){
      return $this->capthaBuilder->inline();
    }

    return $this->capthaBuilder->get();
  }

  /**
  * @inheritdoc
  */
  public function verify($identifier,$value)
  {
    $capthaSessionValue=$session->get($identifier);
    return $capthaSessionValue && $value===$capthaSessionValue;
  }

}
