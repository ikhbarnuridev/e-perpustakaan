<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cover',
        'author',
        'publisher',
        'year_published',
        'stock',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, BookCategory::class);
    }

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    public function availableStock(): int
    {
        $totalBorrowed = $this->borrowings()
            ->whereIn('status', [
                Borrowing::STATUS_PENDING,
                Borrowing::STATUS_APPROVED,
                Borrowing::STATUS_BORROWED,
            ])
            ->count();

        return $this->stock - $totalBorrowed;
    }

    public function isBorrowedBy(User $user): bool
    {
        return $this->borrowings()
            ->where('user_id', $user->id)
            ->where('book_id', $this->id)
            ->whereIn('status', [
                Borrowing::STATUS_PENDING,
                Borrowing::STATUS_APPROVED,
                Borrowing::STATUS_BORROWED,
            ])
            ->exists();
    }

    public function canBeBorrowed(): bool
    {
        return ($this->availableStock() > 0) && ! $this->isBorrowedBy(auth()->user());
    }
}
