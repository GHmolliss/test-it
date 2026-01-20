<?php

declare(strict_types=1);

return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Каталог книг - Console',

    'import' => [
        'application.Models.*',
        'application.Components.*',
        'application.Services.*',
        'application.Repositories.*',
    ],

    'commandMap' => [
        'migrate' => [
            'class' => 'system.cli.commands.MigrateCommand',
            'migrationPath' => 'application.Migrations',
            'migrationTable' => 'migration',
            'connectionID' => 'db',
        ],
        'sms' => [
            'class' => 'application.Commands.SmsCommand',
        ],
    ],

    'components' => [
        'db' => [
            'connectionString' => 'mysql:host=database;dbname=books_catalog',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8mb4',
            'tablePrefix' => '',
        ],

        'authManager' => [
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'itemTable' => 'auth_item',
            'itemChildTable' => 'auth_item_child',
            'assignmentTable' => 'auth_assignment',
        ],
    ],

    'params' => [
        'smsPilotApiKey' => 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ',
    ],
];
