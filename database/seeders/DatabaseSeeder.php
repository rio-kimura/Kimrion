<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::factory()->create(['name' => '管理者 太郎', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'role' => 1]);
        User::factory(10)->create();
        Author::factory(10)->has(Book::factory()->count(3))->create();
    }
}
