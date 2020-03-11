<?php

namespace Project\Controller;

use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\Translator;
use Twig\Environment;
use Zend\Config\Config;

abstract class BaseControllerAbstract
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->request = $this->container->get(Request::class);
        $this->config = $this->container->get(Config::class);
        $this->logger = $this->container->get(LoggerInterface::class);
        $this->getCapsule(); // we need call it first to initialize, maybe we need search a better implementation
    }

    /**
     * @param array $params
     * @return Response
     */
    abstract protected function handleRequest(array $params = []): Response;

    /**
     * @param array $params
     * @return Response
     * @throws \Exception
     */
    public function handle(array $params = [])
    {
        $this->registerErrorHandler();
        try {
            $response = $this->beforeHandleRequest($params);
            if ($response == null) {
                $response = $this->handleRequest($params);
            }
        } catch (\Throwable $exception) {
            $response = $this->handleException($exception);
        }
        restore_error_handler();
        return $response;
    }

    /**
     * @param array $params
     * @return null|Response
     */
    protected function beforeHandleRequest(array $params = []): ?Response
    {
        return null;
    }

    protected function registerErrorHandler()
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if (!(error_reporting() & $errno)) {
                return;
            }
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }

    /**
     * @param \Throwable $throwable
     * @return Response
     */
    protected function handleException(\Throwable $throwable)
    {
        $this->logger->error($throwable);
        return (new Response('An error occurred!'))->setStatusCode(500);
    }

    /**
     * @param $url
     * @param int $statusCode
     * @param array $headers
     * @return RedirectResponse
     */
    protected function redirectToRoute($routeName, $statusCode = 302, array $headers = [])
    {
        return $this->redirect($this->getRouter()->generate($routeName), $statusCode, $headers);
    }

    /**
     * @param $url
     * @param int $statusCode
     * @param array $headers
     * @return RedirectResponse
     */
    protected function redirect($url, $statusCode = 302, array $headers = [])
    {
        return new RedirectResponse($url, $statusCode, $headers);
    }

    /**
     * @param $template
     * @param array $context
     * @param int $statusCode
     * @param array $headers
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function render($template, array $context = [], $statusCode = 200, array $headers = [])
    {
        $context['current_route'] = $this->container->get('current_route');
        return new Response($this->getTwig()->render($template, $context), $statusCode, $headers);
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     * @return Response
     */
    protected function toJson(array $data = [], $statusCode = 200, array $headers = [])
    {
        $headers['content-type'] = 'application/json; charset=utf-8;';
        return new Response(json_encode($data), $statusCode, $headers);
    }

    /**
     * @param $content
     * @param int $statusCode
     * @param array $headers
     * @return Response
     */
    protected function toPlain($content = '', $statusCode = 200, array $headers = [])
    {
        $headers['content-type'] = 'text/plain; charset=utf-8;';
        return new Response($content, $statusCode, $headers);
    }

    /**
     * @return Environment
     */
    protected function getTwig(): Environment
    {
        return $this->container->get(Environment::class);
    }

    /**
     * @return Translator
     */
    protected function getTranslator(): Translator
    {
        return $this->container->get(Translator::class);
    }

    /**
     * @return Session
     */
    protected function getSession(): Session
    {
        return $this->container->get(Session::class);
    }

    /**
     * @return Manager
     */
    protected function getCapsule(): Manager
    {
        return $this->container->get(Manager::class);
    }

    /**
     * @return Router
     */
    protected function getRouter(): Router
    {
        return $this->container->get(Router::class);
    }
}
