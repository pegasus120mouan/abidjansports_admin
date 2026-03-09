<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenoms',
        'contact',
        'role',
        'avatar',
        'signature',
        'statut',
        'email',
        'password',
    ];

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('assets/img/avatars/' . $this->avatar);
        }
        
        $initials = strtoupper(substr($this->prenoms, 0, 1) . substr($this->nom, 0, 1));
        return 'https://ui-avatars.com/api/?name=' . urlencode($initials) . '&background=3949ab&color=fff&size=100';
    }

    public function getDisplayNameAttribute()
    {
        return $this->signature ?: $this->prenoms . ' ' . $this->nom;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'statut' => 'boolean',
        ];
    }
}
