<?php

declare(strict_types=1);

return [
    'name' => [
        'singular' => 'Book Loan',
        'plural' => 'Book Loans',
    ],
    'columns' => [
        'id' => [
            'name' => 'ID',
        ],
        'user_id' => [
            'name' => 'Member',
        ],
        'book_id' => [
            'name' => 'Book',
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
            'name' => 'Status',
        ],
        'rejection_reason' => [
            'name' => 'Rejection Reason',
        ],
        'created_at' => [
            'name' => 'Created Date',
        ],
        'updated_at' => [
            'name' => 'Updated Date',
        ],
    ],
];
