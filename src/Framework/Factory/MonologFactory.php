<?php

namespace Framework\Factory;

use Framework\RequestId;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Zend\Config\Config;

class MonologFactory
{
    /**
     * @param RequestId $requestId
     * @param Config $config
     * @return LoggerInterface
     * @throws \Exception
     */
    public function __invoke(RequestId $requestId, Config $config)
    {
        $hostname = (string) gethostname();
        $logFile = $config->logger->path . '/' . $config->logger->default_name . '-' . $config->environment . '.log';
        $logger = new Logger($config->logger->default_name);
        $logger->pushProcessor(function ($record) use ($requestId, $hostname) {
            $record['extra']['requestId'] = $requestId->__toString();
            $record['extra']['hostname'] = $hostname;
            return $record;
        });

        $defaultFileHandler = new RotatingFileHandler($logFile, $config->logger->level);
        $logger->pushHandler($defaultFileHandler);
        return $logger;
    }
}
