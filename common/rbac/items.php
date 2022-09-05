<?php

return [
    'admin' => [
        'type' => 1,
        'description' => 'Администратор',
        'children' => [
            'student',
        ],
    ],
    'canAdmin' => [
        'type' => 2,
        'description' => 'могучий админ',
    ],
    'student' => [
        'type' => 1,
        'description' => 'Студент',
        'children' => [
            'user',
        ],
    ],
    'user' => [
        'type' => 1,
        'description' => 'Пользователь',
    ],
    'guest' => [
        'type' => 1,
        'description' => 'Гость',
    ],
];
