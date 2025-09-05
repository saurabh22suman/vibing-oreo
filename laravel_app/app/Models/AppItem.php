<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppItem extends Model
{
    use HasFactory;

    protected $table = 'apps';

    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'category',
    ];
}
