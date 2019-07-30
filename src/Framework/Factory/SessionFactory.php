<?php

namespace Framework\Factory;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Zend\Config\Config;

class SessionFactory
{
    /**
     * @param ContainerInterface $container
     * @return Session
     */
    public function __invoke(ContainerInterface $container): Session
    {
        $pdo = $container->get(\PDO::class);
        $config = $container->get(Config::class);
        $storageHandler = new PdoSessionHandler($pdo, [
            'db_table' => 'session',
            'db_id_col' => 'id',
            'db_data_col' => 'data',
            'db_lifetime_col' => 'lifetime',
            'db_time_col' => 'time',
            'lock_mode' => 1
        ]);
        $session = new Session(new NativeSessionStorage($config->session->toArray(), $storageHandler));
        $session->start();
        return $session;
    }
}