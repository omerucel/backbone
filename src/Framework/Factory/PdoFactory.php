<?php

namespace Framework\Factory;

use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;

class PdoFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return $container->get(Manager::class)->getConnection()->getPdo();
    }
}
