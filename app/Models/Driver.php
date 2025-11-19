<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'fullname',
        'email',
        'phone',
        'licenseNumber',
        'licenseExpiry',
        'licensePhoto',
        'vehicleMake',
        'vehicleModel',
        'plateNumber',
        'vehicleReg',
        'orcrUpload',
        'password',
        'currentLocation',
        'current_lat',
        'current_lng',
        'completedBooking',
        'availStatus',
        'serviceType',
        'is_approved',
        'profile_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'licenseExpiry' => 'date',
        'is_approved' => 'boolean',
        'current_lat' => 'float',
        'current_lng' => 'float',
        'availStatus' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'driverID');
    }

    // Get available locations
    public static function getAvailableLocations()
    {
        return [
            'all' => 'All Barangays',
            'Anomar' => 'Anomar',
            'Balibayon' => 'Balibayon',
            'Bonifacio' => 'Bonifacio',
            'Cabongbongan' => 'Cabongbongan',
            'Cagniog' => 'Cagniog',
            'Canlanipa' => 'Canlanipa',
            'Capalayan' => 'Capalayan',
            'Danao' => 'Danao',
            'Day-asan' => 'Day-asan',
            'Ipil' => 'Ipil',
            'Lipata' => 'Lipata',
            'Luna' => 'Luna',
            'Mabini' => 'Mabini',
            'Mabua' => 'Mabua',
            'Mapawa' => 'Mapawa',
            'Mat-i' => 'Mat-i',
            'Nabago' => 'Nabago',
            'Orok' => 'Orok',
            'Poctoy' => 'Poctoy',
            'Quezon' => 'Quezon',
            'Rizal' => 'Rizal',
            'Sabang' => 'Sabang',
            'San Isidro' => 'San Isidro',
            'San Juan' => 'San Juan',
            'San Roque' => 'San Roque',
            'Serna' => 'Serna',
            'Silop' => 'Silop',
            'Sukailang' => 'Sukailang',
            'Taft' => 'Taft',
            'Togbongon' => 'Togbongon',
            'Trinidad' => 'Trinidad',
            'Washington' => 'Washington',
        ];
    }

    // Scope for available drivers
    public function scopeAvailable($query)
    {
        return $query->where('availStatus', true)
                    ->where('approved', true)
                    ->where('currentLocation', '!=', 'all');
    }

    // Get current coordinates as array
    public function getCurrentCoordinates()
    {
        if ($this->current_lat && $this->current_lng) {
            return [
                'lat' => (float) $this->current_lat,
                'lng' => (float) $this->current_lng
            ];
        }
        return null;
    }

    // Update location with coordinates
    public function updateLocation($latitude, $longitude, $locationName = null)
    {
        $this->update([
            'current_lat' => $latitude,
            'current_lng' => $longitude,
            'currentLocation' => $locationName ?: $this->currentLocation
        ]);
    }

    // Increment completed bookings
    public function incrementCompletedBookings()
    {
        $this->increment('completedBooking');
    }

    // Mark as available
    public function markAsAvailable()
    {
        $this->update(['availStatus' => true]);
    }

    // Mark as unavailable
    public function markAsUnavailable()
    {
        $this->update(['availStatus' => false]);
    }

    // Get profile image URL
    public function getProfileImageUrl()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return asset('images/fastlan.png');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    public function getRatingPercentageAttribute()
    {
        return ($this->average_rating / 5) * 100;
    }
        
}