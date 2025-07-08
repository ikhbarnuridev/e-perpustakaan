<?php

declare(strict_types=1);

return [
    'name' => [
        'singular' => 'Buku',
        'plural' => 'Buku',
    ],
    'columns' => [
        'id' => [
            'name' => 'ID',
        ],
        'cover' => [
            'name' => 'Sampul',
        ],
        'author' => [
            'name' => 'Penulis',
        ],
        'publisher' => [
            'name' => 'Penerbit',
        ],
        'year_published' => [
            'name' => 'Tahun Terbit',
        ],
        'stock' => [
            'name' => 'Stok',
        ],
        'created_at' => [
            'name' => 'Tanggal Dibuat',
        ],
        'updated_at' => [
            'name' => 'Tanggal Diperbarui',
        ],
    ],
];
