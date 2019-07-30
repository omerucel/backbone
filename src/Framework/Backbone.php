<?php

namespace Framework;

use DI\ContainerBuilder;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Framework\Factory\CapsuleFactory;
use Framework\Factory\Doctrine\Migration\ConfigurationFactory;
use Framework\Factory\LoggerHelperFactory;
use Framework\Factory\PdoFactory;
use Framework\Factory\RequestFactory;
use Framework\Factory\RouterFactory;
use Framework\Factory\SessionFactory;
use Framework\Factory\SwiftMailerFactory;
use Framework\Factory\TranslatorFactory;
use Framework\Factory\TwigFactory;
use Framework\Logger\LoggerHelper;
use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
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
     * @var string
     */
    protected $basePath;

    /**
     * @var array
     */
    protected $serviceDefinitions;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param $basePath
     * @param array $serviceDefinitions
     */
    public function __construct($basePath, $serviceDefinitions = [])
    {
        $this->basePath = $basePath;
        $this->serviceDefinitions = $serviceDefinitions;
        $this->loadEnv();
        $this->setupContainer();
        $this->loadConfigs();
    }

    protected function loadEnv()
    {
        (new Dotenv())->load($this->basePath . '/.env');
    }

    /**
     * @throws \Exception
     */
    protected function setupContainer()
    {
        $definitions = array_replace($this->getDefaultDefinitions(), $this->serviceDefinitions);
        $this->container = (new ContainerBuilder())->addDefinitions($definitions)->build();
    }

    protected function loadConfigs()
    {
        $configs = include($this->basePath . '/app/configs/config.php');
        $configs['base_path'] = $this->basePath;
        $configs['environment'] = getenv('PROJECT_ENV');
        $config = new Config($configs, true);
        $this->container->set(Config::class, $config);
    }

    /**
     * @return array
     */
    protected function getDefaultDefinitions()
    {
        return [
            \PDO::class => \DI\factory(PdoFactory::class),
            LoggerHelper::class => \DI\factory(LoggerHelperFactory::class),
            Session::class => \DI\factory(SessionFactory::class),
            Request::class => \DI\factory(RequestFactory::class),
            Environment::class => \DI\factory(TwigFactory::class),
            Router::class => \DI\factory(RouterFactory::class),
            Configuration::class => \DI\factory(ConfigurationFactory::class),
            Manager::class => \DI\factory(CapsuleFactory::class),
            \Swift_Mailer::class => \DI\factory(SwiftMailerFactory::class),
            Translator::class => \DI\factory(TranslatorFactory::class)
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
        return $this->config;
    }
}
