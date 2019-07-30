<?php

namespace Framework\Factory;

use Psr\Container\ContainerInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\Translator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;
use Zend\Config\Config;

class TwigFactory
{
    /**
     * @param ContainerInterface $container
     * @return \Twig_Environment
     */
    public function __invoke(ContainerInterface $container): Environment
    {
        $config = $container->get(Config::class);
        $router = $container->get(Router::class);
        $translator = $container->get(Translator::class);
        $loader = new FilesystemLoader($config->twig->templates_path);
        $twig = new Environment($loader, $config->twig->toArray());
        $twig->addFunction(new TwigFunction('path', function ($name, array $params = []) use ($router) {
            return $router->generate($name, $params);
        }));
        $twig->addFunction(new TwigFunction('url', function ($name, array $params = []) use ($router) {
            return $router->generate($name, $params, Router::ABSOLUTE_URL);
        }));
        $twig->addFunction(new TwigFunction('trans', function ($name, array $params = []) use ($translator) {
            return $translator->trans($name, $params);
        }));
        return $twig;
    }
}
