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
        Schema::create('destination', function (Blueprint $table) {
            $table->id('id_destination');
            $table->string('name_destination');
            $table->text('destination_description');
            $table->date('date');
            $table->string('address');
            $table->string('status_trip');
            $table->integer('participant');
            $table->string('rundown');
            $table->string('social_media');
            $table->string('link_whatsapp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination');
    }
};
