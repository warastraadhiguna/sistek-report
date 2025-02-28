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
        Schema::create('visitation_images', function (Blueprint $table) {
            $table->id(); // INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->smallInteger('user_id')->unsigned(); // SMALLINT(5) UNSIGNED NOT NULL
            $table->integer('visitation_id')->unsigned(); // INT(10) UNSIGNED NOT NULL
            $table->string('title', 100); // VARCHAR(100) NOT NULL
            $table->string('image', 250); // VARCHAR(250) NOT NULL
            $table->text('note'); // TEXT NOT NULL
            $table->dateTime('created_at'); // DATETIME NOT NULL
            $table->dateTime('updated_at'); // DATETIME NOT NULL

            // Foreign Key Constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('visitation_id')->references('id')->on('visitations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitation_images');
    }
};