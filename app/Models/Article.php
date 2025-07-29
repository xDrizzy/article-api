<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory ;
    // Colonne d'autorisation d'écriture
    protected $fillable =[
        'title',
        'content',
        'published',
    ];

    protected $cast =[
        'published' => 'boolean',
    ];
}

