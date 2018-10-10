<?php
namespace AppBundle\ServiceFactories;

use Doctrine\ORM\EntityManagerInterface;

class RepositoryFactory
{
  /**
  * @param EntityManagerInterface $entityManager The doctrine entity Manager
  * @param String $entityName The name of the entity
  * @return Class
  */
  public static function repositoryAsAService(EntityManagerInterface $entityManager,$entityName)
  {
    return $entityManager->getRepository($entityName);
  }
}
