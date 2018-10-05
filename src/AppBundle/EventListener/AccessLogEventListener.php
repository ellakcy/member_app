<?php
namespace AppBundle\EventListener;

class AccessLogEventListener
{
  private $logger=null;

    public function __construct(LoggerInterface $logger)
    {
      $this->logger=$logger;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
    }
}
