<?php
namespace AppBundle\Interfaces\EmailSenderInterface;

use AppBundle\Interfaces\EmailSenderInterface;
use \Swift_Mailer;
use \Swift_Message;

class NormalEmailSend implements EmailSenderInterface
{

  /**
  * @var Swift_Mailer
  */
  private $mailer=null;

  public function __construct(Swift_Mailer $mailer)
  {
    $this->mailer=$mailer;
  }

  /**
  * @inheritdoc
  */
  public function send($from,$to,$bodyPlain="",$bodyHtml="",$title="",array $cc=[],array $bcc=[])
  {

    $message=new Swift_Message($title);
    $message->setFrom($from)->setTo($to)->setBody($bodyPlain,'text/plain');

    if($bodyHtml){
        $message->addPart($bofyHtml,'text/html');
    }

    $headers = $message->getHeaders();
    $headers->addTextHeader('X-Agent','ellakcy_member_app');

    $this->mailer->send($message)
  }


}
