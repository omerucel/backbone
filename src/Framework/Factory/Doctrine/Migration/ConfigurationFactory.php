<?php

namespace Framework\Factory\Doctrine\Migration;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Psr\Container\ContainerInterface;
use Zend\Config\Config;

class ConfigurationFactory
{
    /**
     * @param ContainerInterface $container
     * @return Configuration
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __invoke(ContainerInterface $container): Configuration
    {
        $config = $container->get(Config::class);
        $pdo = $container->get(\PDO::class);
        $configuration = new Configuration(DriverManager::getConnection(['pdo' => $pdo]));
        $configuration->setName($config->doctrine->migration->name);
        $configuration->setMigrationsNamespace($config->doctrine->migration->namespace);
        $configuration->setMigrationsTableName($config->doctrine->migration->table_name);
        $configuration->setMigrationsDirectory($config->doctrine->migration->directory);
        return $configuration;
    }
}