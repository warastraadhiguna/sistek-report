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
        Schema::create('taxpayers', function (Blueprint $table) {
            $table->id(); // INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->smallInteger('user_id')->unsigned(); // SMALLINT(5) UNSIGNED NOT NULL
            $table->string('number', 20)->nullable(); // VARCHAR(20) DEFAULT NULL
            $table->string('name', 250); // VARCHAR(250) NOT NULL
            $table->string('business_name', 250)->nullable(); // VARCHAR(250) DEFAULT NULL
            $table->text('address'); // TEXT NOT NULL
            $table->string('email', 250)->nullable(); // VARCHAR(250) DEFAULT NULL
            $table->string('phone', 100); // VARCHAR(100) NOT NULL
            $table->text('note')->nullable(); // TEXT NULLABLE
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
        Schema::dropIfExists('taxpayers');
    }
};