<?php

namespace Framework;

use DI\ContainerBuilder;
use function DI\factory;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Framework\Factory\CapsuleFactory;
use Framework\Factory\ConfigFactory;
use Framework\Factory\Doctrine\Migration\ConfigurationFactory;
use Framework\Factory\MonologFactory;
use Framework\Factory\PdoFactory;
use Framework\Factory\RequestFactory;
use Framework\Factory\RouterFactory;
use Framework\Factory\SessionFactory;
use Framework\Factory\SwiftMailerFactory;
use Framework\Factory\TranslatorFactory;
use Framework\Factory\TwigFactory;
use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\Translator;
use Twig\Environment;
use Zend\Config\Config;

class Backbone
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param $basePath
     * @param array $serviceDefinitions
     * @throws \Exception
     */
    public function __construct($basePath, $serviceDefinitions = [])
    {
        $this->loadEnv($basePath);
        $this->setupContainer($serviceDefinitions);
    }

    /**
     * @param $basePath
     */
    protected function loadEnv($basePath)
    {
        $dotenv = new Dotenv();
        $dotenv->load($basePath . '/.env');
        $dotenv->populate(['PROJECT_BASE_PATH' => $basePath]);
    }

    /**
     * @param array $serviceDefinitions
     * @throws \Exception
     */
    protected function setupContainer($serviceDefinitions = [])
    {
        $definitions = array_replace($this->getDefaultDefinitions(), $serviceDefinitions);
        $this->container = (new ContainerBuilder())->addDefinitions($definitions)->build();
    }

    /**
     * @return array
     */
    protected function getDefaultDefinitions()
    {
        return [
            Config::class => factory(ConfigFactory::class),
            \PDO::class => factory(PdoFactory::class),
            LoggerInterface::class => factory(MonologFactory::class),
            Session::class => factory(SessionFactory::class),
            Request::class => factory(RequestFactory::class),
            Environment::class => factory(TwigFactory::class),
            Router::class => factory(RouterFactory::class),
            Configuration::class => factory(ConfigurationFactory::class),
            Manager::class => factory(CapsuleFactory::class),
            \Swift_Mailer::class => factory(SwiftMailerFactory::class),
            Translator::class => factory(TranslatorFactory::class)
        ];
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->container->get(Config::class);
    }
}
