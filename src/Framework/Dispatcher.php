<?php

namespace Framework;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

class Dispatcher
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
     * @var Router
     */
    protected $router;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->request = $container->get(Request::class);
        $this->router = $container->get(Router::class);
    }

    public function dispatch()
    {
        $matchedRoute = $this->findCurrentRoute();
        $controller = explode('::', $matchedRoute['_controller']);
        $class = $controller[0];
        $action = $controller[1] ?? 'handle';
        $object = $this->container->get($class);
        $response = call_user_func_array([$object, $action], [$matchedRoute]);
        $response->send();
    }

    /**
     * @return array
     */
    protected function findCurrentRoute()
    {
        $matchedRoute = $this->router->matchRequest($this->request);
        $this->container->set('current_route', $matchedRoute);
        return $matchedRoute;
    }
}
