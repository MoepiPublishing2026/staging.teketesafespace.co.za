<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    // Defines the exact table name
    protected $table = 'newsletters';

    // Allows these fields to be populated safely via your admin form
    protected $fillable = [
        'title',
        'category',
        'publish_date',
        'author',
        'image',
        'full_context',
    ];
}