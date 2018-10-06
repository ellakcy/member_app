<?php

namespace Tests\AppBundle\Services\Adapters;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Services\Adapters\RepositoryServiceAdapter;

class RepositoryServiceAdapterTest extends TestCase
{

  private function mockService($fakeClass)
  {
    $mockEntityManager=$this->createMock(EntityManagerInterface::class);
    $mockEntityManager->method('getRepository')->will($this->returnValue($fakeClass));

    return new RepositoryServiceAdapter($mockEntityManager,'Someclass');
  }

  public function testMethodCalled()
  {
    /*
    A Doctrine repository is actually a class,
    so de define an anonymous class and a method
    in order to emulate the behavior.
    */
    $fakeRepository=new class{
          public function myFunction($arg1,$arg2)
          {
            //Dummy logic to test if called
            return $arg1+$arg2;
          }
    };
    $adapter=$this->mockService($fakeRepository);

    $expectedResult=$fakeRepository->myFunction(1,2);
    //Calling the method via the adapter
    $result=$adapter->myFunction(1,2);

    $this->assertEquals($expectedResult,$result);
  }

}
