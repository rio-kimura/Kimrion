<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
>>>>>>> origin/rinon
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
<<<<<<< HEAD
    use HasFactory;

    protected $fillable = ['name', 'kana', 'biography'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
=======
    //
}
>>>>>>> origin/rinon
