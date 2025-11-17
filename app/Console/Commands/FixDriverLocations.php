<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Driver;

class FixDriverLocations extends Command
{
    protected $signature = 'fix:driver-locations';
    protected $description = 'Fix driver location data types';

    public function handle()
    {
        $drivers = Driver::whereNotNull('current_lat')->get();
        
        foreach ($drivers as $driver) {
            if (is_string($driver->current_lat)) {
                $driver->current_lat = (float) $driver->current_lat;
                $driver->current_lng = (float) $driver->current_lng;
                $driver->save();
                $this->info("Fixed driver {$driver->id}");
            }
        }
        
        $this->info('All driver locations fixed!');
        return 0;
    }
}