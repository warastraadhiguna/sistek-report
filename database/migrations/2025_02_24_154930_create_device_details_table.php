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
        Schema::create('device_details', function (Blueprint $table) {
            $table->tinyIncrements('id'); // TINYINT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->smallInteger('user_id')->unsigned(); // SMALLINT(5) UNSIGNED NOT NULL
            $table->tinyInteger('device_type_id')->unsigned(); // TINYINT(3) UNSIGNED NOT NULL
            $table->string('name', 100); // VARCHAR(100) NOT NULL
            $table->dateTime('created_at'); // DATETIME NOT NULL
            $table->dateTime('updated_at'); // DATETIME NOT NULL

            // Foreign Key Constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('device_type_id')->references('id')->on('device_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_details');
    }
};