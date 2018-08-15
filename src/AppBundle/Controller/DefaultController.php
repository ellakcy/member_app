<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Gregwar\Captcha\CaptchaBuilder;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $session=$this->get('session');
        $builder = $this->get('app.captcha');
        $builder->build();
        $session->set('registration_step2',$builder->getPhrase());

        return $this->render('pages/registration.html.twig',[
          'image'=>$builder->inline()
        ]);
    }

    /**
    * @Route("registration/email", name="registration_email_contact")
    * @Method("POST")
    */
    public function addEmailAction(Request $request){

    }
}
