<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Psr\Log\LoggerInterface;
use \AppBundle\Services\CapthaServiceAdapter;


class DefaultController extends Controller
{

    const CAPTHA_KEY_REGISTRATION='registration_step2';

    /**
    * @todo Make my own service in order to handle captha
    */
    private function createCaptcha($sessionKey)
    {
      $builder=$this->get(CapthaServiceAdapter::class);
      return $builder->build($sessionKey,CapthaServiceAdapter::IMAGE_INLINE);
    }

    /**
    * Creates a Json Response when Something wrong has happened
    * @param String $errorMessage The error Message needed when the error occurs
    * @param String $capthaKey The index of the captha in order to get verified
    * @param Integer $httpStatus A valid HttpStatur Response
    */
    private function createErrorJsonResponse($errorMessage,$httpStatus=JsonResponse::HTTP_BAD_REQUEST,$capthaKey=self::CAPTHA_KEY_REGISTRATION)
    {
      $capthaService=$this->get(CapthaServiceAdapter::class);

      $response=[
        'data'=>$errorMessage,
        'newCaptha'=>$this->createCaptcha(self::CAPTHA_KEY_REGISTRATION)
      ];

      return new JsonResponse($response,$httpStatus,['Cache-control','private, max-age=0, no-cache']);
    }



    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        return $this->render('pages/registration.html.twig',[
          'image'=>$this->createCaptcha(self::CAPTHA_KEY_REGISTRATION),
          'captha_key'=>self::CAPTHA_KEY_REGISTRATION
        ]);
    }

    /**
    * @Route("registration/email", name="registration_email_contact")
    * @Method("POST")
    * @todo Have common code for handling the Ajax Errors
    */
    public function addEmailAction(Request $request,LoggerInterface $logger)
    {
      $capthaService=$this->get(CapthaServiceAdapter::class);
      $capthaUserValue=$request->request->get('captcha');

      if(!$request->isXmlHttpRequest()){
        return $this->createErrorJsonResponse("This is not an AJAX request",JsonResponse::HTTP_BAD_REQUEST);
      } else if(!$capthaService->verify('registration_step2',$capthaUserValue)){
        return $this->createErrorJsonResponse("The provided captha is not the valid one",JsonResponse::HTTP_BAD_REQUEST);
      }

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
          $response=['data'=>$emailToReturn->getEmail()];
          return new JsonResponse($response,JsonResponse::HTTP_OK);
        } else {
          return new JsonResponse("The provided email is not a valid one. You gave the value:".$contactEmail,JsonResponse::HTTP_BAD_REQUEST);
        }

      }catch(UniqueConstraintViolationException $u){
        return new JsonResponse(['data'=>'Email has already provided']);
      }catch( \Exception $e) {
        $logger->error('An exception had been thrown: '.$e->getMessage());
        return $this->createErrorJsonResponse("Internal Error",JsonResponse::HTTP_INTERNAL_ERROR);
      }
    }

    /**
    * Generates the Captcha Image
    * @Route("/captha/{identifier}.jpg", name="captcha_image")
    * @Method("GET")
    */
    public function capthaAction($identifier)
    {
      $capthaService=$this->get(CapthaServiceAdapter::class);
      $image=$capthaService->build($key,CapthaServiceAdapter::IMAGE_NORMAL);

      $response=new Response($image,Response::HTTP_OK,['Cache-control','private, max-age=0, no-cache']);
      $response->headers->set('Content-Type','image/jpeg');

      return $response;
    }
}
