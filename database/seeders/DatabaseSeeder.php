<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. 管理者ユーザー (ログイン用: admin@example.com / password)
        User::factory()->create([
            'name' => '管理者 太郎',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        // 2. 一般ユーザー 10人
        User::factory(10)->create();

        // 3. 著者10人 × 本3冊 (合計30冊)
        // ランキング表示などに必要なデータです
        Author::factory(10)
            ->has(Book::factory()->count(3))
            ->create();
    }
}
