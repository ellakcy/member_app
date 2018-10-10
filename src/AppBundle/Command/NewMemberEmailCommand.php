<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Repository\ContactEmailRepository;

class NewMemberEmailCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('member:new:email')
            ->setDescription('Sends or fills the spools with the correct email for new members');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $container=$this->getContainer();

        /**
        * @var AppBundle\Repository\ContactEmailRepository
        */
        $contactEmailService=$container->get(ContactEmailRepository::class);

        /**
        * @var AppBundle\Services\NormalEmailSend
        */
        $mailer=$container->get(\AppBundle\Services\NormalEmailSend::class);

        $addresseToSendFrom=$container->getParameter('notification_email_address');
        $emails=$contactEmailService->getEmailListInOrderToSendEmail();

        foreach($emails as $email){
          //@todo: Somehow provide content to email invitation
          $mailer->send($addresseToSendFrom,$email,"EllakCy Member Registration","AHHAHA","AHHHA");
        }
    }

}
