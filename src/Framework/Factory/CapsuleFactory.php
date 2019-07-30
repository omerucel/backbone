<?php

namespace Framework\Factory;

use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Zend\Config\Config;

class CapsuleFactory
{
    /**
     * @param ContainerInterface $container
     * @return Manager
     */
    public function __invoke(ContainerInterface $container): Manager
    {
        $config = $container->get(Config::class);
        $capsule = new Manager();
        $capsule->addConnection($config->capsul->toArray());
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        return $capsule;
    }
}
