<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\HasRolesAndPermissions;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndPermissions, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'stripe_price_id',
        'subscription_status',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function structure()
    {
        return $this->hasOne(Structure::class);
    }

    /**
     * Check if the user has a valid subscription (for referents)
     */
    public function hasValidSubscription()
    {
        // Non-referents don't need subscriptions
        if (!$this->hasRole('referent')) {
            return true;
        }

        // Check Cashier subscription status
        if ($this->subscribed('default') || $this->onTrial('default')) {
            return true;
        }

        // Check custom subscription status
        return in_array($this->subscription_status, ['active', 'trialing']);
    }

    /**
     * Get subscription plan name based on price ID
     */
    public function getSubscriptionPlanAttribute()
    {
        $priceMapping = [
            env('STRIPE_PRICE_STARTER') => 'Starter',
            env('STRIPE_PRICE_PROFESSIONAL') => 'Professional',
            env('STRIPE_PRICE_ENTERPRISE') => 'Enterprise'
        ];

        return $priceMapping[$this->stripe_price_id] ?? 'Free';
    }
}
