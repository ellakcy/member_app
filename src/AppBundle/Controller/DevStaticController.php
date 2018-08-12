<?php
/**
* Controller with routes for displaying static content
* for html/css debugging
* @author Dimtrios Desyllas
*/

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DevStaticController extends Controller
{
  /**
  * Route to Debug the Paper Application Form used for
  * Member registration
  */
  public function paperApplicationFormAction(Request $request)
  {
    return $this->render('templates/applicationForm/applicationForm.html.twig',[
      'name'=> "John",
      'surname'=>'Doe',
      'email'=>'jdoe@example.com',
      'idNum'=>'AE12353',
      'idCountry'=>'Cypriot',
      'signatureBase64img'=>'https://dummyimage.com/100x100/000/fff.png',
      'qrCodeBase64Img'=>'https://dummyimage.com/100x100/000/fbf.png'
    ]);
  }

}
