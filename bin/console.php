<?php

namespace  {

    use Framework\Console;
    use Framework\Backbone;
    use Project\Console\Command\CreateUserCommand;

    $basePath = realpath(__DIR__ . '/../');
    require_once $basePath . '/vendor/autoload.php';

    $backbone = new Backbone($basePath);
    $console = $backbone->getContainer()->get(Console::class);
    $console->add($backbone->getContainer()->get(CreateUserCommand::class));
    $console->run();
}
