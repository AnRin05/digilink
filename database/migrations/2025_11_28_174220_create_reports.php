<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('reports');
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_type');
            $table->text('description');
            $table->string('reporter_type');
            $table->unsignedBigInteger('reporter_id');
            $table->unsignedBigInteger('booking_id');
            $table->json('location_data')->nullable();
            $table->json('booking_data')->nullable();
            $table->json('driver_data')->nullable();
            $table->json('passenger_data')->nullable();
            $table->string('status')->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('bookingID')->on('bookings')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
};