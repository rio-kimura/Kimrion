<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            //著者ID author_id: BIGINT, FK(authors.id), 削除時カスケード
            $table->foreignId('author_id')
                    ->constrained('authors')
                    ->onDelete('cascade');
            //書籍名 title: VARCHAR, Index, Not Null
            $table->string('title')->index();
            //あらすじ description: TEXT, Nullable
            $table->text('description')->nullable();
            //公開状態 status: TINYINT, Default(1)
            $table->tinyInteger('status')
                    ->default(1)
                    ->comment('公開状態 (1:下書き、2:公開)');
            //公開日 published_at: DATE, Index, Nullable
            $table->date('published_at')
                    ->nullable()
                    ->index();
            //閲覧数 view_count: INT, Index, Default(0)
            $table->integer('view_count')
                    ->default(0)
                    ->index();
            $table->timestamps();
            //論理削除用
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
