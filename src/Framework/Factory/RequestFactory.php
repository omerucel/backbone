<?php

namespace Framework\Factory;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return Request::createFromGlobals();
    }
}
