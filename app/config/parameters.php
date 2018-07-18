<?php

// Database Settings
$container->setParameter('database_host', getenv("database_host"));
$container->setParameter('database_port', (int) getenv("database_port"));
$container->setParameter('database_name', getenv("database_name"));
$container->setParameter('database_user', getenv("database_user"));
$container->setParameter('database_password', getenv("database_password"));


//Smtp Settings
$container->setParameter('mailer_transport', 'smtp');
$container->setParameter('mailer_host', getenv('smtp_host'));

$useSmtpSSL=getenv('smtp_use_ssl');
$useSmtpSSL=filter_var($useSmtpSSL, FILTER_VALIDATE_BOOLEAN);
if($useSmtpSSL){
 $container->setParameter('mailer_encryption_method', 'ssl');
}

$container->setParameter('mailer_port', getenv('smtp_port'));
$container->setParameter('mailer_user', getenv('smtp_user'));
$container->setParameter('mailer_password', getenv('smtp_password'));

$container->setParameter('app_name', "Ellakcy Member and user Management System");


$container->setParameter('secret','ncrwoe3398hxujiqwbhdslasTT^ebghuikas');
