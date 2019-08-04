<?php

namespace Project\Console\Command;

use Framework\Console;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;

abstract class CommandAbstract extends Command
{
    /**
     * @return ContainerInterface
     */
    protected function getContainer(): ContainerInterface
    {
        /**
         * @var Console $app
         */
        $app = $this->getApplication();
        return $app->getContainer();
    }
}
