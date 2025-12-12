<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Author;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    // 編集可能なカラム
    protected $fillable = [
        'author_id',
        'title',
        'description',
        'file_path',
        'status',
        'published_at',
        'view_count',
    ];

    // 日付として扱うカラム
    protected $casts = [
        'published_at' => 'date',
    ];

    // リレーション: 本は一人の著者に属する
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
