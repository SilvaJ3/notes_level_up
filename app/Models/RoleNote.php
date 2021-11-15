<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleNote extends Model
{
    use HasFactory;
    public function notes()
    {
        return $this->belongsToMany(Note::class, "note_role_user_pivots");
    }
    public function users()
    {
        return $this->belongsToMany(User::class, "note_role_user_pivots");
    }
}
