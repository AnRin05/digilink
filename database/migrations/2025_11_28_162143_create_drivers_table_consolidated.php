<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First, drop the problematic table if it exists
        Schema::dropIfExists('drivers');
        
        // Then create with the corrected structure
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('licenseNumber')->unique();
            $table->date('licenseExpiry');
            $table->string('licensePhoto');
            $table->string('vehicleMake');
            $table->string('vehicleModel');
            $table->string('plateNumber')->unique();
            $table->string('vehicleReg');
            $table->string('orcrUpload');
            $table->string('profile_image')->nullable();
            $table->string('password');
            $table->boolean('is_approved')->default(false);
            $table->rememberToken();
            $table->timestamps();
            
            $table->enum('currentLocation', [
                'all',
                'Anomar',
                'Balibayon',
                'Bonifacio',
                'Cabongbongan',
                'Cagniog',
                'Canlanipa',
                'Capalayan',
                'Danao',
                'Day-asan',
                'Ipil',
                'Lipata',
                'Luna',
                'Mabini',
                'Mabua',
                'Mapawa',
                'Mat-i',
                'Nabago',
                'Orok',
                'Poctoy',
                'Quezon',
                'Rizal',
                'Sabang',
                'San Isidro',
                'San Juan',
                'San Roque',
                'Serna',
                'Silop',
                'Sukailang',
                'Taft',
                'Togbongon',
                'Trinidad',
                'Washington'
            ])->default('all');
            
            $table->decimal('current_lat', 10, 8)->nullable();
            $table->decimal('current_lng', 11, 8)->nullable();
            $table->enum('serviceType', ['Ride', 'Delivery', 'Both'])->default('Ride');
            $table->integer('completedBooking')->default(0);
            $table->boolean('availStatus')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};