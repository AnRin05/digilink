<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('booking_history');
        Schema::create('booking_history', function (Blueprint $table) {
            $table->id('history_id');
            $table->unsignedInteger('booking_id'); // References bookingID from bookings table
            $table->unsignedInteger('passenger_id');
            $table->unsignedInteger('driver_id')->nullable();
            
            // Booking details (copied from bookings table)
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->decimal('pickup_latitude', 10, 8)->nullable();
            $table->decimal('pickup_longitude', 11, 8)->nullable();
            $table->decimal('dropoff_latitude', 10, 8)->nullable();
            $table->decimal('dropoff_longitude', 11, 8)->nullable();
            $table->decimal('fare', 10, 2);
            $table->enum('status', ['pending', 'accepted', 'in_progress', 'completed', 'cancelled']);
            $table->enum('service_type', ['booking_to_go', 'for_delivery']);
            $table->enum('payment_method', ['cash', 'gcash']);
            $table->text('description')->nullable();
            $table->timestamp('schedule_time')->nullable();
            $table->timestamp('driver_completed_at')->nullable();
            $table->timestamp('passenger_completed_at')->nullable();
            $table->enum('completion_verified', [
                'pending', 
                'driver_confirmed', 
                'passenger_confirmed', 
                'both_confirmed'
            ])->default('pending');
            
            // History specific fields
            $table->boolean('is_deleted_by_passenger')->default(false);
            $table->boolean('is_deleted_by_driver')->default(false);
            $table->timestamp('deleted_by_passenger_at')->nullable();
            $table->timestamp('deleted_by_driver_at')->nullable();
            $table->text('deletion_reason')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('booking_id')->references('bookingID')->on('bookings')->onDelete('cascade');
            $table->foreign('passenger_id')->references('passengerID')->on('passengers')->onDelete('cascade');
            $table->foreign('driver_id')->references('driverID')->on('drivers')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index('booking_id');
            $table->index('passenger_id');
            $table->index('driver_id');
            $table->index('status');
            $table->index(['passenger_id', 'is_deleted_by_passenger']);
            $table->index(['driver_id', 'is_deleted_by_driver']);
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_history');
    }
};