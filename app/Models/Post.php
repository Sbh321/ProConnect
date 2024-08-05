<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters)
    {
        if ($filters['hashtag'] ?? false) {
            $query
                ->Where('hashtags', 'like', '%' . request('hashtag') . '%');
        }

        if ($filters['keyword'] ?? false) {
            $query
                ->where('status', 'like', '%' . request('keyword') . '%');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function stars()
    {
        return $this->belongsToMany(User::class, 'stars')->withTimestamps();
    }
    public function saves()
    {
        return $this->belongsToMany(User::class, 'saves')->withTimestamps();
    }

    /**
     * Get the comments for the post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
