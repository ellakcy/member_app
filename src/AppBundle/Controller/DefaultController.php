<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Gregwar\Captcha\CaptchaBuilder;

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

        $session=$this->get('session');
        $builder = $this->get('app.captcha');
        $builder->build();
        $session->set('registration_step2',$builder->getPhrase());

        return $this->render('pages/registration.html.twig',[
          'image'=>$this->createCaptcha('registration_step2')
        ]);
    }

    /**
    * @Route("registration/email", name="registration_email_contact")
    * @Method("POST")
    * @todo Have common code for handling the Ajax Errors
    */
    public function addEmailAction(Request $request)
    {
      $response=[
        'newCaptha' => $this->createCaptcha('registration_step2'),
      ];

      $csrf = $this->get('form.csrf_provider');
      $session=$this->get('session');

      $existingCSRF=$request->request->get('csrf');
      $capthaSessionValue=$session->get('registration_step2');
      $capthaUserValue=$request->request->get('captcha');

      if(
        !$request->isXmlHttpRequest() ||
        !$this->isCsrfTokenValid('insert-email',$existingCSRF) ||
        $capthaSessionValue!==$capthaUserValue
      ){
        return new JSONResponse(400,$response);
      }

      $response['csrf']=$csrf->refreshToken('insert-email');

      /**
      * @var AppBundle\Repository\ContactEmailRepository
      * @todo Create Specialized Service for proxying the Repositories
      */
      $contactEmailHandler=$this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:ContactEmail');

      try {
        $contactEmail=$request->request->get('email');
        $contactEmailNew=filter_var($contactEmail,FILTER_VALIDATE_EMAIL);

        if($contactEmailNew){
          /**
          * @var AppBundle\Entity\ContactEmail
          */
          $emailToReturn=$contactEmailHandler->addEmail($contactEmailNew);

          $response['data']=$emailToReturn->getEmail();
          return new JSONResponse($response);

        } else {
          $response['data']="The provided email is not a valid one.";
          $response['valueProvided']=$contactEmail;
          return new JSONResponse(400,$response);
        }

      } catch( Exception $e) {
        $response['data']=$e->getMessage();
        return new JSONResponse(500,$response);
      }
    }
}
