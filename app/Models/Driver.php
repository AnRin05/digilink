<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

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
        'profile_image',
        'password',
        'is_approved',
        'currentLocation',
        'current_lat',
        'current_lng',
        'completedBooking',
        'availStatus',
        'serviceType',
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

        public function setPasswordAttribute($value)
    {
        // Only hash if the value is not already hashed
        if (!empty($value) && !preg_match('/^\$2y\$/', $value)) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    /**
     * Custom password verification that handles both bcrypt and plain text
     */
    public function validatePassword($password)
    {
        // If password is bcrypted, use Hash::check
        if (preg_match('/^\$2y\$/', $this->password)) {
            return Hash::check($password, $this->password);
        }
        
        // If password is plain text, compare directly (and then migrate to bcrypt)
        if ($this->password === $password) {
            // Migrate to bcrypt
            $this->password = Hash::make($password);
            $this->save();
            return true;
        }
        
        return false;
    }

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

    // Scope for available drivers - FIXED: changed 'approved' to 'is_approved'
    public function scopeAvailable($query)
    {
        return $query->where('availStatus', true)
                    ->where('is_approved', true) // FIXED THIS LINE
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

    // Get profile image URL with error handling
    public function getProfileImageUrl()
    {
        try {
            if ($this->profile_image) {
                return asset('storage/' . $this->profile_image);
            }
            return asset('images/fastlan.png');
        } catch (\Exception $e) {
            Log::error('Error getting profile image URL: ' . $e->getMessage());
            return asset('images/fastlan.png');
        }
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Add error handling to accessors
    public function getAverageRatingAttribute()
    {
        try {
            return $this->reviews()->avg('rating') ?: 0;
        } catch (\Exception $e) {
            Log::error('Error calculating average rating: ' . $e->getMessage());
            return 0;
        }
    }

    public function getTotalReviewsAttribute()
    {
        try {
            return $this->reviews()->count();
        } catch (\Exception $e) {
            Log::error('Error counting reviews: ' . $e->getMessage());
            return 0;
        }
    }

    public function getRatingPercentageAttribute()
    {
        try {
            return ($this->average_rating / 5) * 100;
        } catch (\Exception $e) {
            Log::error('Error calculating rating percentage: ' . $e->getMessage());
            return 0;
        }
    }
    public function systemFeedbacks()
    {
        return $this->hasMany(SystemFeedback::class);
    }

    public function hasGivenFeedbackRecently($days = 7)
    {
        return $this->systemFeedbacks()
            ->where('created_at', '>=', now()->subDays($days))
            ->exists();
    }

    public function getAverageSatisfactionRating()
    {
        return $this->systemFeedbacks()->avg('satisfaction_rating') ?: 0;
    }
}