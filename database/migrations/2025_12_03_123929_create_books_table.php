<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
            $table->string('title')->index();
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:下書き, 2:公開');
            $table->date('published_at')->nullable()->index();
            $table->integer('view_count')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('books'); }
};
