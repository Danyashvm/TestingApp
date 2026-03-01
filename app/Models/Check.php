<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    protected $fillable = [
        'text',
        'search_word',
        'total_words',
        'found_words',
    ];
}
