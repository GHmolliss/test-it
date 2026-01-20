<?php

declare(strict_types=1);

return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Каталог книг',
    'defaultController' => 'site',
    'language' => 'ru',

    // Пути к директориям с заглавной буквы
    'controllerPath' => dirname(__FILE__) . '/../Controllers',
    'viewPath' => dirname(__FILE__) . '/../Views',
    'runtimePath' => dirname(__FILE__) . '/../Runtime',

    'import' => [
        'application.Models.*',
        'application.Components.*',
        'application.Forms.*',
        'application.Services.*',
        'application.Repositories.*',
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

        'urlManager' => [
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'login' => 'auth/login',
                'logout' => 'auth/logout',
                'register' => 'auth/register',
                'books' => 'book/index',
                'books/create' => 'book/create',
                'books/<id:\d+>' => 'book/view',
                'books/<id:\d+>/edit' => 'book/update',
                'books/<id:\d+>/delete' => 'book/delete',
                'authors' => 'author/index',
                'authors/create' => 'author/create',
                'authors/<id:\d+>' => 'author/view',
                'authors/<id:\d+>/edit' => 'author/update',
                'authors/<id:\d+>/delete' => 'author/delete',
                'authors/<id:\d+>/subscribe' => 'subscription/subscribe',
                'report' => 'report/index',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],

        'user' => [
            'class' => 'CWebUser',
            'allowAutoLogin' => true,
            'loginUrl' => ['auth/login'],
        ],

        'authManager' => [
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'itemTable' => 'auth_item',
            'itemChildTable' => 'auth_item_child',
            'assignmentTable' => 'auth_assignment',
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'session' => [
            'class' => 'CDbHttpSession',
            'connectionID' => 'db',
            'sessionTableName' => 'session',
        ],
    ],

    'params' => [
        'smsPilotApiKey' => 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ',
        'uploadPath' => 'uploads/books/',
    ],
];
