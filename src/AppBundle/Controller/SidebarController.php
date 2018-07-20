<?php

/**
* @author Dimitrios Desyllas
* I created this controller in order to place methods that render
* some dynamic content to the sidebar. I use this approach in order to have
* widget-like approach views for specific sidebar parts
*/

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SidebarController extends Controller
{

  public function displayCurrentUserInfoToTheSideBarAction()
  {
    $auth_checker = $this->get('security.authorization_checker');
    $token = $this->get('security.token_storage')->getToken();
    $user = $token->getUser();
    return $this->render('widgets/sidebar_profile.html.twig',['user'=>$user]);
  }

}
