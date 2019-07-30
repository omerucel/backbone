<?php

namespace Framework\Factory;

use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Zend\Config\Config;

class RouterFactory
{
    /**
     * @param ContainerInterface $container
     * @return Router
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get(Config::class);
        $request = $container->get(Request::class);
        $routeFile = $config->basePath . '/app/configs/routes.yml';
        $resourceDir = dirname($routeFile);
        $fileLocator = new FileLocator($resourceDir);
        $loader = new YamlFileLoader($fileLocator);
        $context = (new RequestContext())->fromRequest($request);
        return new Router($loader, basename($routeFile), [], $context);
    }
}
