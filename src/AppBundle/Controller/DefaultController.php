<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Psr\Log\LoggerInterface;


class DefaultController extends Controller
{

    /**
    * @todo Make my own service in order to handle captha
    */
    private function createCaptcha($sessionKey)
    {
      $session=$this->get('session');
      $builder = $this->get('app.captcha');
      $builder->build();
      $session->set($sessionKey,$builder->getPhrase());

      return $builder->inline();
    }

    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        return $this->render('pages/registration.html.twig',[
          'image'=>$this->createCaptcha('registration_step2')
        ]);
    }

    /**
    * @Route("registration/email", name="registration_email_contact")
    * @Method("POST")
    * @todo Have common code for handling the Ajax Errors
    */
    public function addEmailAction(Request $request,LoggerInterface $logger)
    {
      $csrf = $this->get('security.csrf.token_manager');
      $session=$this->get('session');

      $existingCSRF=$request->request->get('csrf');
      $capthaSessionValue=$session->get('registration_step2');
      $capthaUserValue=$request->request->get('captcha');

      $response=[
        'newCaptha' => $this->createCaptcha('registration_step2'),
      ];

      if(!$request->isXmlHttpRequest()){
        $response['data']="This is not an AJAX request";
        return new JsonResponse($response,JsonResponse::HTTP_BAD_REQUEST);
      } else if($capthaSessionValue!==$capthaUserValue){
        $response['data']="The provided captha is not the valid one";
        return new JsonResponse($response,JsonResponse::HTTP_BAD_REQUEST);
      }

      $response['csrf']=$csrf->refreshToken('insert-email');

      /**
      * @var AppBundle\Repository\ContactEmailRepository
      * @todo Create Specialized Service for proxying the Repositories
      */
      $contactEmailHandler=$this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:ContactEmail');

      try {
        $contactEmail=$request->request->get('autofill_email');
        $contactEmailNew=filter_var($contactEmail,FILTER_VALIDATE_EMAIL);

        if($contactEmailNew){
          /**
          * @var AppBundle\Entity\ContactEmail
          */
          $emailToReturn=$contactEmailHandler->addEmail($contactEmailNew);

          $response['data']=$emailToReturn->getEmail();
          return new JsonResponse($response,JsonResponse::HTTP_OK);

        } else {
          $response['data']="The provided email is not a valid one.";
          $response['valueProvided']=$contactEmail;
          return new JsonResponse($response,JsonResponse::HTTP_BAD_REQUEST);
        }

      }catch(UniqueConstraintViolationException $u){
        return new JsonResponse($response);
      }catch( \Exception $e) {
        $logger->error('An exception had been thrown: '.$e->getMessage());
        $response['data']="Internal Error";
        return new JsonResponse($response,JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
      }
    }
}
