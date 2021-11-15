<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    public function tags() 
    {
        return $this->belongsToMany(Tag::class, "note_tag_pivots");
    }

    public function likes() 
    {
        return $this->belongsTo(Like::class, "like_id", "id");
    }

    public function role_notes()
    {
        return $this->belongsToMany(RoleNote::class, "note_role_user_pivots");
    }

    public function users()
    {
        return $this->belongsToMany(User::class, "note_role_user_pivots");
    }
}
