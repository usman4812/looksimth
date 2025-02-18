<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Diet;
use App\Models\Address;
use App\Models\Ingredient;
use App\Models\PlanVariant;
use App\Models\EhMealUserDiet;
use Laravel\Sanctum\HasApiTokens;
use App\Models\EhMealSubscription;
use App\Models\EhMealCustomerGroup;
use App\Models\EhMealUserIngredient;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'customer_group_id',
        'auth_number',
        'active',
        'service_id',
        'image',
        'phone',
        'gender',
        'address',
        'status',
        'device_token',
        'about',
        'online_status',
        'percentage',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_user', 'user_id', 'service_id');
    }
    public function bookings(){

        return $this->hasMany(Booking::class);
    }
}
