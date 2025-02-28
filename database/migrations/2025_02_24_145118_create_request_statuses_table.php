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
        Schema::create('request_statuses', function (Blueprint $table) {
            $table->tinyIncrements('id'); // TINYINT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->smallInteger('user_id')->unsigned(); // SMALLINT(5) UNSIGNED NOT NULL
            $table->string('name', 100); // VARCHAR(100) NOT NULL
            $table->dateTime('created_at'); // DATETIME NOT NULL
            $table->dateTime('updated_at'); // DATETIME NOT NULL

            // Foreign Key Constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_statuses');
    }
};