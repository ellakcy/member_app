<?php
namespace AppBundle\Services\Adapters;

use Doctrine\ORM\EntityManagerInterface;

class RepositoryServiceAdapter
{
        private $repository=null;

        /**
        * @param EntityManagerInterface the Doctrine entity Manager
        * @param String $entityName The name of the entity that we will retrieve the repository
        */
        public function __construct(EntityManagerInterface $entityManager,$entityName)
        {
            $this->repository=$entityManager->getRepository($entityName);
        }

        public function __call($name,$arguments)
        {
          if(empty($arguments)){ //No arguments has been passed
            return $this->repository->$name();
          } else {
            //@todo: figure out how to pass the parameters
            return $this->repository->$name(...$arguments);
          }
        }
}
