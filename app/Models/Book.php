<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
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
}
