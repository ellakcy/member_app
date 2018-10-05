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

    $query->execute();
  }

  /**
  * List and Seatch for existing emails
  * @param Integer $page The pagination page
  * @param Integet $limit The page limit
  * @return String[]
  */
  public function getEmailListInOrderToSendEmail($page=1,$limit=100)
  {
    $em=$this->getEntityManager();

    $queryBuilder = $em->createQueryBuilder();
    $queryBuilder->select('c.email')->from(ContactEmail::class,'c');

    if($limit>0 && $page>0){
      $page=$page-1;
      $queryBuilder->setFirstResult($page)->setMaxResults($limit);
    } else if($limit>0){
      $queryBuilder->setFirstResult(0)->setMaxResults($limit);
    }

    $value=$queryBuilder->getQuery()->execute();

    if(empty($value)){
      return [];
    }

    return $value;
  }

  /**
  * List and Seatch for existing emails
  * @param String $email
  * @return Boolean
  */
  public function emailExists($email)
  {
      $em=$this->getEntityManager();
      $queryBuilder = $em->createQueryBuilder();

      $queryBuilder->select('c.email')
        ->from(ContactEmail::class,'c')
        ->where('c.email=:email')
        ->setParameter(':email', $email)
        ->setMaxResults(1);

      $value=$queryBuilder->getQuery()->getOneOrNullResult();

      return $value!=null;
  }

}
