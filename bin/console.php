<?php

namespace  {

    use Framework\Console;
    use Framework\Backbone;

    $basePath = realpath(__DIR__ . '/../');
    require_once $basePath . '/vendor/autoload.php';

    $backbone = new Backbone($basePath);
    $console = $backbone->getContainer()->get(Console::class);
    $console->run();
}
