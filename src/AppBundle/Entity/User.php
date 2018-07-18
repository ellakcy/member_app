<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=25,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=25,
     *     minMessage="The surname is too short.",
     *     maxMessage="The surname is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $surname;

    /**
     * @ORM\Column(type="phone_number")
     * @AssertPhoneNumber
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=0,
     *     max=255,
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $organization;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=0,
     *     max=255,
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $occupation;

    public function __construct()
    {
        parent::__construct();
    }

    public function setName(string $name)
    {
      $this->name=$name;

      return $this;
    }

    public function getName()
    {
        return $this->name;
    }


    public function setSurname(string $surname)
    {
      $this->surname=$surname;

      return $this;
    }

    public function getSurname()
    {
        return $this->name;
    }

    public function setPhone($phoneNum)
    {
      $this->phone=$phoneNum;

      return $this;
    }

    public function getPhone()
    {
      return $this->phone;
    }

    public function setOrganization($organization)
    {
      $this->organization=$organization;
      return $this;
    }

    public function getOrganization()
    {
      return $this->organization;
    }

    public function setOccupation($occupation)
    {
      $this->occupation=$occupation;
      return $this;
    }

    public function getOccupation()
    {
      return $this->occupation;
    }
}
