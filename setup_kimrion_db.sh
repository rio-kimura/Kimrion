#!/bin/bash
set -e

# --- 設定値 ---
DB_HOST="192.168.56.11"
DB_PORT="5432"
DB_NAME="laravel_db"
DB_USER="laravel_user"
DB_PASS="SecretPassword123!"

# Discord通知設定
DISCORD_WEBHOOK_URL="https://discord.com/api/webhooks/1443474577781952688/hmC_clTpA8bYKnK9d9ZO2e-eF0O1BdQ4BjB30g9calEga3Op9gEWLGG-_6EWb06gvAau"

echo "🚀 書籍管理システム アプリケーション環境構築..."

# 通知関数
send_discord() {
    local message="$1"
    if [[ "$DISCORD_WEBHOOK_URL" == http* ]]; then
        curl -H "Content-Type: application/json" \
             -X POST \
             -d "{\"content\": \"$message\"}" \
             "$DISCORD_WEBHOOK_URL" > /dev/null 2>&1
    fi
}

# 1. .env生成
echo "📝 .envファイルを生成中..."
cat <<ENV_EOF > .env
APP_NAME=Kimrion
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://192.168.56.10

APP_TIMEZONE=Asia/Tokyo
APP_LOCALE=ja
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=ja_JP

LOG_CHANNEL=stack
DB_CONNECTION=pgsql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT}
DB_DATABASE=${DB_NAME}
DB_USERNAME=${DB_USER}
DB_PASSWORD=${DB_PASS}

SESSION_DRIVER=file
CACHE_STORE=file
ENV_EOF

echo "🔑 キー生成とキャッシュクリア..."
php artisan key:generate
php artisan config:clear

# 2. マイグレーションファイル生成
echo "🏗️ マイグレーションファイルを生成中..."

# Users Table
USER_MIGRATION=$(find database/migrations -name "*create_users_table.php" | head -n 1)
if [ -n "$USER_MIGRATION" ]; then
cat <<PHP_EOF > "$USER_MIGRATION"
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint \$table) {
            \$table->id();
            \$table->string('name');
            \$table->string('email')->unique();
            \$table->timestamp('email_verified_at')->nullable();
            \$table->string('password');
            \$table->tinyInteger('role')->default(0)->comment('0:一般, 1:管理者');
            \$table->rememberToken();
            \$table->timestamps();
            \$table->softDeletes();
        });
        Schema::create('password_reset_tokens', function (Blueprint \$table) {
            \$table->string('email')->primary();
            \$table->string('token');
            \$table->timestamp('created_at')->nullable();
        });
        Schema::create('sessions', function (Blueprint \$table) {
            \$table->string('id')->primary();
            \$table->foreignId('user_id')->nullable()->index();
            \$table->string('ip_address', 45)->nullable();
            \$table->text('user_agent')->nullable();
            \$table->longText('payload');
            \$table->integer('last_activity')->index();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
PHP_EOF
fi

# Authors Table
if [ -z "$(find database/migrations -name "*create_authors_table.php")" ]; then
    php artisan make:migration create_authors_table > /dev/null
fi
AUTHOR_MIGRATION=$(find database/migrations -name "*create_authors_table.php" | head -n 1)
cat <<PHP_EOF > "$AUTHOR_MIGRATION"
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authors', function (Blueprint \$table) {
            \$table->id();
            \$table->string('name')->index();
            \$table->string('kana')->nullable()->index();
            \$table->text('biography')->nullable();
            \$table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('authors'); }
};
PHP_EOF

# Books Table
if [ -z "$(find database/migrations -name "*create_books_table.php")" ]; then
    php artisan make:migration create_books_table > /dev/null
fi
BOOK_MIGRATION=$(find database/migrations -name "*create_books_table.php" | head -n 1)
cat <<PHP_EOF > "$BOOK_MIGRATION"
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
            \$table->string('title')->index();
            \$table->text('description')->nullable();
            \$table->string('file_path')->nullable();
            \$table->tinyInteger('status')->default(1)->comment('1:下書き, 2:公開');
            \$table->date('published_at')->nullable()->index();
            \$table->integer('view_count')->default(0)->index();
            \$table->timestamps();
            \$table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('books'); }
};
PHP_EOF

# 3. モデル生成
echo "🧠 モデルファイルを生成中..."
php artisan make:model Author > /dev/null 2>&1 || true
php artisan make:model Book > /dev/null 2>&1 || true

cat <<PHP_EOF > app/Models/User.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;
    protected \$fillable = ['name', 'email', 'password', 'role'];
    protected \$hidden = ['password', 'remember_token'];
    protected function casts(): array {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }
}
PHP_EOF

cat <<PHP_EOF > app/Models/Author.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected \$fillable = ['name', 'kana', 'biography'];
    public function books() { return \$this->hasMany(Book::class); }
}
PHP_EOF

cat <<PHP_EOF > app/Models/Book.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;
    protected \$fillable = ['author_id', 'title', 'description', 'file_path', 'status', 'published_at', 'view_count'];
    protected \$casts = ['published_at' => 'date'];
    public function author() { return \$this->belongsTo(Author::class); }
}
PHP_EOF

# 4. Factory & Seeder
echo "🌱 FactoryとSeederを生成中..."
php artisan make:factory AuthorFactory > /dev/null 2>&1 || true
php artisan make:factory BookFactory > /dev/null 2>&1 || true

cat <<PHP_EOF > database/factories/UserFactory.php
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string \$password;
    public function definition(): array {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::\$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 0,
        ];
    }
}
PHP_EOF

cat <<PHP_EOF > database/factories/AuthorFactory.php
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class AuthorFactory extends Factory {
    public function definition(): array {
        return [
            'name' => fake()->name(),
            'kana' => fake()->kanaName(),
            'biography' => fake()->realText(200),
        ];
    }
}
PHP_EOF

cat <<PHP_EOF > database/factories/BookFactory.php
<?php
namespace Database\Factories;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
class BookFactory extends Factory {
    public function definition(): array {
        return [
            'author_id' => Author::factory(),
            'title' => fake()->realText(20),
            'description' => fake()->realText(100),
            'file_path' => null,
            'status' => fake()->numberBetween(1, 2),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'view_count' => fake()->numberBetween(0, 5000),
        ];
    }
}
PHP_EOF

cat <<PHP_EOF > database/seeders/DatabaseSeeder.php
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
PHP_EOF

# 5. 実行
echo "🚀 データベースを再構築しています..."
php artisan migrate:fresh --seed --force

echo "✅ [アプリ] 環境構築とデータ投入が完了しました！"
send_discord "🎉 **アプリケーション(Laravel)環境構築完了！**\nDB接続: 成功\nマイグレーション: 完了\nシーディング: 完了"
