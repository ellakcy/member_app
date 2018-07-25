<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
      $auth_checker = $this->get('security.authorization_checker');
      $token = $this->get('security.token_storage')->getToken();
      $user = $token->getUser();

      if($auth_checker->isGranted('ROLE_USER')){
        return $this->render('pages/panel.html.twig');
      } else {
        $router = $this->container->get('router');
        return new RedirectResponse($router->generate('fos_user_security_login'));
      }
    }
}
