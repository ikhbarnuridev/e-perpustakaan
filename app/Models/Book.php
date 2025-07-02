<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
