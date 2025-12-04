<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Passenger extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'fullname',
        'email',
        'phone',
        'profile_image',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
        public function getProfileImageUrl()
    {
        try {
            if ($this->profile_image) {
                return asset('storage/' . $this->profile_image);
            }
            return asset('images/default-avatar.png'); // Make sure this file exists
        } catch (\Exception $e) {
            return asset('images/default-avatar.png');
        }
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
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

    #public function getAverageSatisfactionRating()
    #{
     #   return $this->systemFeedbacks()->avg('satisfaction_rating') ?: 0;
    #}
    public function getAverageSatisfactionRating()
   {
       return (int) ($this->systemFeedbacks()->avg('satisfaction_rating') ?? 0);
   }

}