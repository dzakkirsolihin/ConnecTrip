<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trip_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained('trip_submissions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('full_name');
            $table->integer('age');
            $table->string('whatsapp');
            $table->string('emergency_contact');
            $table->string('instagram');
            $table->boolean('terms')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trip_registrations');
    }
};