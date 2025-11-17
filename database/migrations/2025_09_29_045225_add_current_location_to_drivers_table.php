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
        Schema::table('drivers', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            //
        });
    }
};
