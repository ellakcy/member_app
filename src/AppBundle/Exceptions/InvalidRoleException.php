<?php
namespace AppBundle\Exceptions;

class InvalidRoleException extends \Exception{

  private $user=false;

  /**
  * @param $role {String} The role of the user
  */
  public function __construct(string $role){
    parent::__construct("The role $role does not exist");
  }
}
