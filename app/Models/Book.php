<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // 編集可能なカラムを指定（念のため）
    protected $fillable = ['title', 'author_id', 'file_path', 'published_at', 'view_count'];

    // 著者とのリレーション（本は一人の著者に属する）
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
