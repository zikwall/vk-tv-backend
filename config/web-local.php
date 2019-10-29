<?php return [
    'components' => [
        'clickhouse' => [
            'class' => 'kak\clickhouse\Connection',
            'dsn' => '[::1]',
            'port' => '8123',
            'database' => 'monit',
            'username' => 'default',
            'password' => '123',
            'enableSchemaCache' => true,
            'schemaCache' => 'cache',
            'schemaCacheDuration' => 86400
        ],
        'cache' => [
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                ]
            ],
        ],
    ]
];