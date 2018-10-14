<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true, nullable=true)
     */
    private $displayName;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     * @Assert\Email( message = "The email '{{ value }}' is not a valid email.")
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];


    public function __construct()
    {
        $this->isActive = false;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }

    public function getUsername()
    {
        return $this->displayName;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
      $roles = $this->roles;
      // give everyone ROLE_USER!
      if (!in_array('ROLE_USER', $roles)) {
        $roles[] = 'ROLE_USER';
      }
      return $roles;
    }

    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
      return true;
    }

    public function isAccountNonLocked()
    {
      return true;
    }

    public function isCredentialsNonExpired()
    {
        return !empty($this->password);
    }

    public function isEnabled()
    {
          return $this->isActive && !empty($this->password);
    }


    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->$displayName,
            $this->password,
            $this->email,
            $this->isActive,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->$displayName,
            $this->password,
            $this->email,
            $this->isActive,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
    }
}
