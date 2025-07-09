<?php

declare(strict_types=1);

return [
    'name' => [
        'singular' => 'User',
        'plural' => 'Users',
    ],
    'columns' => [
        'id' => [
            'name' => 'ID',
        ],
        'name' => [
            'name' => 'Name',
        ],
        'nis' => [
            'name' => 'Student ID (NIS)',
        ],
        'email' => [
            'name' => 'Email Address',
        ],
        'email_verified_at' => [
            'name' => 'Email Verified At',
        ],
        'password' => [
            'name' => 'Password',
        ],
        'remember_to' => [
            'name' => 'Remember Me',
        ],
        'created_at' => [
            'name' => 'Created At',
        ],
        'updated_at' => [
            'name' => 'Updated At',
        ],
    ],
];
