<?php

$basePath = realpath(__DIR__ . '/../../');
$appPath = realpath(__DIR__ . '/../');

error_reporting(E_ALL);
ini_set('error_log', $basePath . '/var/log/php_error.log');
ini_set('log_errors', true);
ini_set('display_errors', false);
date_default_timezone_set(getenv('PROJECT_TIMEZONE'));

return [
    'basePath' => $basePath,
    'project_url' => getenv('PROJECT_URL'),
    'asset_base_path' => getenv('ASSET_BASE_PATH'),
    'routes' => $appPath . '/configs/routes.yml',
    'capsul' => [
        'driver' => getenv('CAPSUL_DRIVER'),
        'host' => getenv('CAPSUL_HOST'),
        'port' => intval(getenv('CAPSUL_PORT')),
        'database' => getenv('CAPSUL_DATABASE'),
        'username' => getenv('CAPSUL_USERNAME'),
        'password' => getenv('CAPSUL_PASSWORD'),
        'charset' => getenv('CAPSUL_CHARSET')
    ],
    'logger' => [
        'default_name' => 'app',
        'path' => $basePath . '/var/log',
        'level' => intval(getenv('LOGGER_LEVEL'))
    ],
    'twig' => [
        'auto_reload' => getenv('TWIG_AUTO_RELOAD') === 'true',
        'templates_path' => $appPath . '/templates',
        'cache' => $basePath . '/var/cache/twig',
    ],
    'doctrine' => [
        'migration' => [
            'name' => 'Project',
            'namespace' => 'Project\Database\Migration',
            'table_name' => 'doctrine_migration',
            'directory' => $appPath . '/database/migrations'
        ]
    ],
    'session' => [
        'gc_maxlifetime' => intval(getenv('SESSION_GC_MAXLIFETIME'))
    ],
    'smtp' => [
        'from_email' => getenv('SMTP_FROM_EMAIL'),
        'from_name' => getenv('SMTP_FROM_NAME'),
        'server' => getenv('SMTP_HOST'),
        'port' => intval(getenv('SMTP_PORT')),
        'username' => getenv('SMTP_USERNAME'),
        'password' => getenv('SMTP_PASSWORD'),
        'encryption' => getenv('SMTP_ENCRYPTION')
    ],
    'translations' => [
        'default_locale' => getenv('TRANSLATION_DEFAULT_LOCALE'),
        'fallback_locales' => [getenv('TRANSLATION_FALLBACK_LOCALE')],
        'locales' => [],
        /*
        'locales' => [
            'tr_TR' => [
                'loader' => 'array',
                'file' => realpath($appPath . '/translations/tr_TR.php')
            ],
            'en_US' => [
                'loader' => 'array',
                'file' => realpath($appPath . '/translations/en_US.php')
            ]
        ],*/
        /*
        'locales' => [
            'tr_TR' => [
                'loader' => 'mo',
                'file' => realpath($appPath . '/translations/tr_TR.mo')
            ],
            'en_US' => [
                'loader' => 'mo',
                'file' => realpath($appPath . '/translations/en_US.mo')
            ]
        ],*/
    ]
];
