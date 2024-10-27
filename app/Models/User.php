<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'referral_code',
        'referral_by',
        'role',
        'avatar',
        'phone',
        'address',
        'bank_account',
        'bank_name',
        'bank_branch',
        'bank_owner',
        'username',
        'balance',
        'usdt_balance',
        'usdt_total_withdraw',
        'usdt_total_deposit',
        'total_withdraw',
        'total_deposit',
        'level',
        'accept_info',
        'status',
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

    public function referralBy()
    {
        return $this->belongsTo(User::class, 'referral_by');
    }

    public function teamMembers()
    {
        return $this->hasMany(User::class, 'referral_by');
    }

    public function teamMembersThisMonth()
    {
        return $this->hasMany(User::class, 'referral_by')->where('created_at', '>=', now()->subMonth());
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }
}
