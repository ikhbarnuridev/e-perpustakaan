<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrowing extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_BORROWED = 'borrowed';

    public const STATUS_RETURNED = 'returned';

    // Status Labels
    public const STATUSES = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REJECTED => 'Rejected',
        self::STATUS_BORROWED => 'Borrowed',
        self::STATUS_RETURNED => 'Returned',
    ];

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
        'rejection_reason',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function approve(): void
    {
        $this->status = Borrowing::STATUS_APPROVED;
        $this->save();
    }

    public function reject(): void
    {
        $this->status = Borrowing::STATUS_REJECTED;
        $this->save();
    }

    public function confirmPickup(): void
    {
        $this->status = Borrowing::STATUS_BORROWED;
        $this->save();
    }

    public function confirmReturn(): void
    {
        $this->status = Borrowing::STATUS_RETURNED;
        $this->returned_at = now();
        $this->save();
    }

    public function isPending(): bool
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function isApporved(): bool
    {
        return $this->status == self::STATUS_APPROVED;
    }

    public function isBorrowed(): bool
    {
        return $this->status == self::STATUS_BORROWED;
    }
}
