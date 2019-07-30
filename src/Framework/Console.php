<?php

namespace Framework;

use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Zend\Config\Config;

class Console extends Application
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
        $this->setupLoggerName();
        $this->setupDoctrine();
    }

    protected function setupLoggerName()
    {
        $config = $this->container->get(Config::class);
        $config->logger->default_name = 'console';
    }

    protected function setupDoctrine()
    {
        $configuration = $this->container->get(Configuration::class);
        $this->getHelperSet()->set(new ConnectionHelper($configuration->getConnection()));
        $this->getHelperSet()->set(new ConfigurationHelper(
            $configuration->getConnection(),
            $configuration
        ));
        \Doctrine\DBAL\Tools\Console\ConsoleRunner::addCommands($this);
        \Doctrine\DBAL\Migrations\Tools\Console\ConsoleRunner::addCommands($this);
    }

    public function getContainer()
    {
        return $this->container;
    }
}
