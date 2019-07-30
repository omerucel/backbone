<?php

namespace Framework\Factory;

use Framework\Logger\LoggerHelper;
use Framework\RequestId;
use Zend\Config\Config;

class LoggerHelperFactory
{
    /**
     * @param RequestId $requestId
     * @param Config $config
     * @return LoggerHelper
     */
    public function __invoke(RequestId $requestId, Config $config)
    {
        $configs = $config->logger->toArray();
        $configs['app_environment'] = $config->environment;
        return new LoggerHelper($requestId, $configs);
    }
}
