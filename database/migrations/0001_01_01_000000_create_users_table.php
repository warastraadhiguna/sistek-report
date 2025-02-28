<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('users', function (Blueprint $table) {
            $table->smallIncrements('id'); // SMALLINT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->smallInteger('user_id')->unsigned()->nullable(); // SMALLINT(5) UNSIGNED NULL
            $table->tinyInteger('role_id')->unsigned(); // TINYINT(3) UNSIGNED NOT NULL
            $table->string('name', 191); // VARCHAR(191) NOT NULL
            $table->string('email', 191)->unique(); // UNIQUE KEY
            $table->timestamp('email_verified_at')->nullable(); // TIMESTAMP NULL DEFAULT NULL
            $table->string('password', 191); // VARCHAR(191) NOT NULL
            $table->rememberToken(); // VARCHAR(100) DEFAULT NULL
            $table->timestamps(); // created_at & updated_at

            // Foreign Key Constraints
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
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