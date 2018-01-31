<?php
return [
    'dynamic' => [
        'type' => 1,
        'description' => 'Динамические правила',
        'ruleName' => 'dynamic',
    ],
    'user' => [
        'type' => 1,
        'description' => 'Авторизованный пользователь',
        'ruleName' => 'userRole',
        'children' => [
            'dynamic',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Администратор',
        'ruleName' => 'userRole',
    ],
    'god' => [
        'type' => 1,
        'description' => 'GodMode',
        'ruleName' => 'userRole',
        'children' => [
            'admin',
        ],
    ],
];
