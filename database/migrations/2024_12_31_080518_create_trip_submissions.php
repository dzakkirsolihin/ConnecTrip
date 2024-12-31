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
            $table->string('trip_name');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('meeting_point');
            $table->string('whatsapp_group');
            $table->string('social_media')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('capacity');
            $table->text('payment_info');
            $table->boolean('is_public')->default(false);
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
