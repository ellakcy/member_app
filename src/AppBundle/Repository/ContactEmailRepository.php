<?php

namespace AppBundle\Repository;

use AppBundle\Entity\ContactEmail;

/**
 * ContactEmailRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactEmailRepository extends \Doctrine\ORM\EntityRepository
{
  /**
  * Adding an Email to the database
  * @param String $email
  *
  * @throws Doctrine\DBAL\Exception\UniqueConstraintViolationException
  *
  * @return AppBundle\Entity\ContactEmail
  */
  public function addEmail($email)
  {
      $emailToAdd=new ContactEmail();
      $emailToAdd->setEmail($email);


      $em=$this->getEntityManager();

      $em->persist($emailToAdd);
      $em->flush();

      return $emailToAdd;
  }

  /**
  * Remove an email from the database
  * @param String $email
  */
  public function deleteEmail($email)
  {
    $em=$this->getEntityManager();

    $queryBuilder = $em->createQueryBuilder();
    $queryBuilder->delete(ContactEmail::class,'c')
      ->where('c.email=:email')
      ->setParameter('email',$email);

    $query=$queryBuilder->getQuery();

    $p = $query->execute();

    return $p;
  }

  /**
  * List and Seatch for existing emails
  * @param String $email
  *
  * @return String[]
  */
  public function getEmailListInOrderToSendEmail($email=null)
  {

  }

  /**
  * List and Seatch for existing emails
  * @param String $email
  *
  * @throws DatabaseCommunicationFailedException
  *
  * @return Boolean
  */
  public function emailExists($email)
  {

  }

}
