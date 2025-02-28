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
        Schema::create('visitations', function (Blueprint $table) {
            $table->id(); // INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->smallInteger('user_id')->unsigned(); // SMALLINT(5) UNSIGNED NOT NULL
            $table->smallInteger('technician_id')->unsigned(); // SMALLINT(5) UNSIGNED NOT NULL
            $table->integer('taxpayer_id')->unsigned(); // INT(10) UNSIGNED NOT NULL
            $table->tinyInteger('activity_id')->unsigned(); // TINYINT(3) UNSIGNED NOT NULL
            $table->tinyInteger('request_status_id')->unsigned(); // TINYINT(3) UNSIGNED NOT NULL
            $table->dateTime('arrival_date'); // DATETIME NOT NULL
            $table->dateTime('return_date'); // DATETIME NOT NULL
            $table->text('detail'); // TEXT NOT NULL
            $table->dateTime('created_at'); // DATETIME NOT NULL
            $table->dateTime('updated_at'); // DATETIME NOT NULL

            // Foreign Key Constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('technician_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('taxpayer_id')->references('id')->on('taxpayers')->onDelete('cascade');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('request_status_id')->references('id')->on('request_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitations');
    }
};