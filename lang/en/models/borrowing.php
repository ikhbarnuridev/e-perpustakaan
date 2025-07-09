<?php

declare(strict_types=1);

return [
    'name' => [
        'singular' => 'Book Loan',
        'plural' => 'Book Loans',
    ],
    'columns' => [
        'id' => [
            'name' => 'Loan ID',
        ],
        'user_id' => [
            'name' => 'Library Member',
        ],
        'book_id' => [
            'name' => 'Book Title',
        ],
        'borrowed_at' => [
            'name' => 'Borrowed Date',
        ],
        'due_date' => [
            'name' => 'Due Date',
        ],
        'returned_at' => [
            'name' => 'Returned Date',
        ],
        'status' => [
            'name' => 'Loan Status',
        ],
        'rejection_reason' => [
            'name' => 'Rejection Reason',
        ],
        'created_at' => [
            'name' => 'Created At',
        ],
        'updated_at' => [
            'name' => 'Updated At',
        ],
    ],
];
