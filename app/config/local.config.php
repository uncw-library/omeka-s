<?php
return [
    'logger' => [
        'log' => true,
        'priority' => \Laminas\Log\Logger::NOTICE,
    ],
    'http_client' => [
        'sslcapath' => null,
        'sslcafile' => null,
    ],
    'cli' => [
        'phpcli_path' => null,
    ],
    'thumbnails' => [
        'types' => [
            'large' => ['constraint' => 800],
            'medium' => ['constraint' => 200],
            'square' => ['constraint' => 200],
        ],
        'thumbnailer_options' => [
            'imagemagick_dir' => null,
        ],
    ],
    'translator' => [
        'locale' => 'en_US',
    ],
    'service_manager' => [
        'aliases' => [
            'Omeka\File\Store' => 'Omeka\File\Store\Local',
            'Omeka\File\Thumbnailer' => 'Omeka\File\Thumbnailer\ImageMagick',
        ],
    ],
    'mail' => [
        'transport' => [
            'type' => 'smtp',
            'options' => [
                'name' => 'smtp-relay.uncw.edu',
                'host' => 'smtp-relay.uncw.edu',
                'port' => 25, // 465 for 'ssl', and 587 for 'tls'
                'connection_class' => 'smtp', // 'smtp', 'login', or 'crammd5'
                'connection_config' => [
                    'username' => null,
                    'password' => null,
                    'ssl' => null, // 'ssl' or 'tls'
                    'use_complete_quit' => true,
                ],
            ],
        ],
    ],
];
