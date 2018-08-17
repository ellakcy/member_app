<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ContactEmail
 *
 * @ORM\Table(name="contact_email")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactEmailRepository")
 * @UniqueEntity("email")
 */
class ContactEmail
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var String
    * @ORM\Column(name="email",type="string",unique=true)
    * @Assert\Email( message = "The email '{{ value }}' is not a valid email.")
    */
    private $email;

    /**
    * @ORM\Column(name="date", type="datetime")
    */
    private $createdAt;

    public function __construct()
    {
      $this->createdAt=new \DateTime("now", new \DateTimeZone("UTC"));
    }

    /**
     * Get id
     *
     * @return int
    */
    public function getId()
    {
        return $this->id;
    }

    /**
    * @param String $email
    * @return ContactEmail
    */
    public function setEmail($email){
      $this->email=$email;

      return $this;
    }

    /**
    * @return String
    */
    public function getEmail(){
      return $this->email;
    }

    public function getCreatedAt()
    {
      return $this->createdAt;
    }
}
