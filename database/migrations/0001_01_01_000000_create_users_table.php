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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // ★追加: 権限 (0:一般, 1:管理者)
            $table->tinyInteger('role')->default(0)->comment('0:一般, 1:管理者');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes(); // ★追加: 論理削除
        });

        // ...下にある sessions 等の記述はそのままでOK
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
