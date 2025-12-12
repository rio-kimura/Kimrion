<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            // 著者ID (著者が削除されたら本も一緒に消える設定)
            $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');

            $table->string('title')->index(); // 書籍名
            $table->text('description')->nullable(); // あらすじ
            $table->string('file_path')->nullable(); // ファイルパス

            // ステータス (1:下書き, 2:公開)
            $table->tinyInteger('status')->default(1)->comment('1:下書き, 2:公開');

            $table->date('published_at')->nullable()->index(); // 公開日
            $table->integer('view_count')->default(0)->index(); // 閲覧数

            $table->timestamps();
            $table->softDeletes(); // 論理削除
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
