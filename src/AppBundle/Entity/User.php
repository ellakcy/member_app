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


    /**
    * @param String $displayName How the user will be viewed to other users (NOT USED for LOGIN)
    * @param String $email The User's Email
    */
    public function __construct($displayName=null, $email=null, array $roles=[], $isActive=false)
    {
        $this->isActive = $isActive;
        $this->setUsername($displayName);
        $this->setEmail($email);
        $this->setRoles($roles);
    }

    /**
    * @param String $displayName How the user will be viewed to other users (NOT USED for LOGIN)
    * @return User
    */
    public function setDisplayName(string $displayName)
    {
      $this->displanName=$displayName;
      return $this;
    }

    /**
    * Alias to setDisplayName method.
    * @param String $username How the user will be viewed to other users (NOT USED for LOGIN)
    * @return User
    */
    public function setUsername($username)
    {
      return $this->setDisplayName($username);
    }

    public function getUsername()
    {
      return !empty($this->displayName)?$this->displayName:$this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setEmail($email)
    {
      $this->email=$email;
      return $this;
    }

    /**
    * @return String
    */
    public function getEmail()
    {
      return $this->email;
    }

    /**
    * Set an ENCODED (Cryptographically Hashed) password to this user
    * @param String $password CRYPTOGRAPHICALLY Hashed password
    */
    public function setPassword(string $password)
    {
      $this->password=$password;
      return $this;
    }

    public function getRoles()
    {
      $roles = $this->roles;
      // give everyone ROLE_USER!
      if (!in_array('ROLE_USER', $roles)) {
        $roles[] = 'ROLE_USER';
      }

      // Append extra autoset logic here

      return $roles;
    }

    /**
    * Adds an extra role to the user
    * @return User
    */
    public function appendRole(string $role)
    {
      if (!in_array($role, $this->roles)) {
        $this->roles[]=$role;
      }

      return $this;
    }

    /**
     * OVERRIDES the user roles
     * @param Array $roles The array of the roles to get overriden
     * @return User
     */
    public function setRoles(array $roles)
    {
      $this->roles=$roles;

      return $this;
    }

    public function eraseCredentials()
    {
      $this->password="";
    }

    public function isCredentialsNonExpired()
    {
        return !empty($this->password);
    }

    public function isEnabled()
    {
          return $this->isActive && !empty($this->password);
    }

    public function enable()
    {
      $this->isActive=true;
      return $this;
    }

    public function disable()
    {
      $this->isActive=false;
      return $this;
    }

    // Methods with default actions
    public function getSalt()
    {
        return null;
    }

    public function isAccountNonExpired()
    {
      return true;
    }

    public function isAccountNonLocked()
    {
      return true;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->displayName,
            $this->password,
            $this->email,
            $this->isActive,
            $this->roles
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->displayName,
            $this->password,
            $this->email,
            $this->isActive,
            $this->roles
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
    }
}
