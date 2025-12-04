<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_id',
        'title',
        'description',
        'file_path',
        'status',
        'published_at',
        'view_count',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}