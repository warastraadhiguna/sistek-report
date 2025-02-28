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
        Schema::create('permissions', function (Blueprint $table) {
            $table->smallIncrements('id'); // SMALLINT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->smallInteger('user_id')->unsigned(); // SMALLINT(5) UNSIGNED NOT NULL
            $table->tinyInteger('resource_id')->unsigned(); // TINYINT(3) UNSIGNED NOT NULL
            $table->tinyInteger('role_id')->unsigned(); // TINYINT(3) UNSIGNED NOT NULL
            $table->boolean('can_view_any')->default(0); // TINYINT(1) DEFAULT 0
            $table->boolean('can_create'); // TINYINT(1)
            $table->boolean('can_edit'); // TINYINT(1)
            $table->boolean('can_delete'); // TINYINT(1)
            $table->dateTime('created_at'); // DATETIME NOT NULL
            $table->dateTime('updated_at'); // DATETIME NOT NULL

            // Foreign Key Constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};