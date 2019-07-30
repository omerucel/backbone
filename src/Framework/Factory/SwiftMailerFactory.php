<?php

namespace Framework\Factory;

use Psr\Container\ContainerInterface;
use Zend\Config\Config;

class SwiftMailerFactory
{
    /**
     * @param ContainerInterface $container
     * @return \Swift_Mailer
     */
    public function __invoke(ContainerInterface $container): \Swift_Mailer
    {
        $config = $container->get(Config::class);
        $transport = new \Swift_SmtpTransport($config->smtp->server, $config->smtp->port, $config->smtp->encryption);
        $transport->setUsername($config->smtp->username);
        $transport->setPassword($config->smtp->password);
        return new \Swift_Mailer($transport);
    }
}
