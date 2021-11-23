<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'image',
        'likes',
        'credits',
        'vote',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(RoleNote::class, "note_role_user_pivots");
    }

    public function notes()
    {
        return $this->belongsToMany(Note::class, "note_role_user_pivots");
    }

    public function role() {
        return $this->belongsTo(Role::class, "role_id", "id");
    }

    public function like() 
    {
        return $this->belongsToMany(Note::class, "likes");
    }

    public function votes() 
    {
        return $this->belongsToMany(Contest::class, "contests");
    }
}
