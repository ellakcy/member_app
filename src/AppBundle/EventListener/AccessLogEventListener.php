<?php
namespace AppBundle\EventListener;

use Symfony\Bridge\Monolog\Logger;
use  Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Twig\Environment; //For formatting thelogs

class AccessLogEventListener
{
    /**
    * @var Logger
    */
    private $logger=null;

    /**
    * @var Environment
    */
    private $twig;

    public function __construct(Logger $logger,Environment $twig)
    {
      $this->logger=$logger;
      $this->twig=$twig;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request=$event->getRequest();
        $response=$event->getResponse();
        $content_type=$response->headers->get('content_type');

        if(!$content_type){
          return;
        }

        $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
        $log=[
            'date'=>gmdate("Y/m/j H:i:s"),
            'http_version'=>$response->getProtocolVersion(),
            'http_method'=>$request->getMethod(),
            'request_ip'=>$request->getClientIp(),
            'url'=>$baseurl,
            'user_agent'=>$request->headers->get('User-Agent'),
            'response_status_code'=>$response-> getStatusCode(),
            'response_type'=>$content_type
        ];

        $log=$this->twig->createTemplate('[{{date}}] HTTP{{http_version}} {{http_method}} {{response_status_code}} {{request_ip}} {{user_agent}} {{url}} {{response_type}}')->render($log);

        $this->logger->info($log);
    }
}
