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
            $table->id(); // 主キー
            $table->foreignId('author_id')->constrained('authors'); // 外部キー（authorsテーブルのidと紐付け）
            $table->string('title'); // 書籍名
            $table->string('file_path')->nullable(); // テキストファイルのパス
            $table->date('published_at')->nullable(); // 公開日
            $table->integer('view_count')->default(0); // 閲覧数（初期値0）
            $table->timestamps();
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
