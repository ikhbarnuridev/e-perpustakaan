<?php

declare(strict_types=1);

return [
    'name' => [
        'singular' => 'Peminjaman',
        'plural' => 'Peminjaman',
    ],
    'columns' => [
        'id' => [
            'name' => 'ID',
        ],
        'user_id' => [
            'name' => 'Anggota',
        ],
        'book_id' => [
            'name' => 'Buku',
        ],
        'borrowed_at' => [
            'name' => 'Tanggal Peminjaman',
        ],
        'due_date' => [
            'name' => 'Batas Pengembalian',
        ],
        'returned_at' => [
            'name' => 'Tanggal Pengembalian',
        ],
        'status' => [
            'name' => 'Status',
        ],
        'rejection_reason' => [
            'name' => 'Alasan Penolakan',
        ],
        'created_at' => [
            'name' => 'Tanggal Dibuat',
        ],
        'updated_at' => [
            'name' => 'Tanggal Diperbarui',
        ],
    ],
];
