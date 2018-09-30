<?php
namespace AppBundle\Interfaces\EmailSenderInterface;

/**
* Interface that allows you to implement ways to send emails.
*/
interface EmailSender
{

  public function send($from,$to,$body_plain,$body_html,array $cc=[],array $bcc=[]);
}
