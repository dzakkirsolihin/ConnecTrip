<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trip_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('trip_name');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('city'); // New field for city
            $table->string('address'); // Full address
            $table->decimal('latitude', 10, 7)->nullable(); // Latitude
            $table->decimal('longitude', 10, 7)->nullable(); // Longitude
            $table->string('ktp_path')->nullable(); // New field for KTP upload
            $table->string('whatsapp_group');
            $table->string('social_media')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('capacity');
            $table->text('notes')->nullable();
            $table->boolean('terms')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_submission');
    }
};
