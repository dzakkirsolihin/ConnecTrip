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
        Schema::create('trip_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained('trip_submissions')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->text('address');
            $table->string('whatsapp');
            $table->string('emergency_contact');
            $table->text('medical_history')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->enum('privacy', ['public', 'private'])->default('private');
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
        Schema::dropIfExists('trip_registrations');
    }
};
