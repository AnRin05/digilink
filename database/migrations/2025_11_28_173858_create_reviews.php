<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('reviews');
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings', 'bookingID')->onDelete('cascade');
            $table->foreignId('passenger_id')->constrained('passengers')->onDelete('cascade');
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('cascade');
            $table->integer('rating')->unsigned()->default(5);
            $table->timestamps();

            // Ensure one review per booking
            $table->unique(['booking_id']);
            
            // Indexes for performance
            $table->index(['driver_id', 'rating']);
            $table->index(['passenger_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};