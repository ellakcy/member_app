<?php
namespace AppBundle\Interfaces\EmailSenderInterface;

/**
* Interface that allows you to implement ways to send emails.
*/
interface EmailSender
{
  /**
  * Basic function to send emails
  * @param String $from Sender's email address where the email will be sent
  * @param String $to Receipient email address
  * @param String $bodyPlain The plaintext body of the email
  * @param String $bodyHtml The html formated body
  * @param String $title The Email's title
  * @param Array $cc The list of Carbon Copy conotified email addresses
  * @param Array $bcc The list of Blind Carbon Copy conotified email addresses
  *
  * @return boolean Indicating whether the email has been sent or not
  */
  public function send($from,$to,$bodyPlain="",$bodyHtml="",$title="",array $cc=[],array $bcc=[]);
}
