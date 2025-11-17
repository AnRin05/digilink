<?php

namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverProfileController extends Controller
{
    public function show($driverId)
    {
        $driver = Driver::with('reviews')->findOrFail($driverId);

        return view('passenger.driver-profile', [
            'driver' => $driver
        ]);
    }
}
