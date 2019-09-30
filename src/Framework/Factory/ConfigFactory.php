<?php

namespace Framework\Factory;

use Psr\Container\ContainerInterface;
use Zend\Config\Config;

class ConfigFactory
{
    /**
     * @param ContainerInterface $container
     * @return Config
     */
    public function __invoke(ContainerInterface $container)
    {
        $configs = include(getenv('PROJECT_BASE_PATH') . '/app/configs/config.php');
        $configs['environment'] = getenv('PROJECT_ENV');
        $config = new Config($configs, true);
        return $config;
    }
}
