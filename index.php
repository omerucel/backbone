<?php

namespace  {

    use Framework\Dispatcher;
    use Framework\Backbone;

    $basePath = realpath(__DIR__ . '/');
    require_once $basePath . '/vendor/autoload.php';

    $backbone = new Backbone($basePath);
    $dispatcher = $backbone->getContainer()->get(Dispatcher::class);
    $dispatcher->dispatch();
}
