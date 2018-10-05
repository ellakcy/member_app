<?php
namespace AppBundle\EventListener;

use Symfony\Bridge\Monolog\Logger;
use  Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class AccessLogEventListener
{
  private $logger=null;

    public function __construct(Logger $logger)
    {
      $this->logger=$logger;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request=$event->getRequest();
        $response=$event->getResponse();

        $log=[
            'date'=>gmdate("Y/m/j H:i:s"),
            'http_version'=>$response->getProtocolVersion(),
            'http_method'=>$request->getMethod(),
            'request_ip'=>$request->getClientIp(),
            'url'=>$request->getRequestUri(),
            'user_agent'=>$request->headers->get('User-Agent'),
            'response_status_code'=>$response-> getStatusCode(),
            'response_type'=>$response->headers->get('content_type')
        ];

        $this->logger->info(json_encode($log));
    }
}
