<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'kana', 'biography'];

    // リレーション: 著者は複数の本を持つ
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
