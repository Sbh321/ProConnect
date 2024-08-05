<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function scopeFilter($query, array $filters)
    {
        if ($filters['keyword'] ?? false) {
            $query
                ->where('name', 'like', '%' . request('keyword') . '%');
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    // Relationship to JobListing
    public function jobListing()
    {
        return $this->hasMany(JobListing::class, 'user_id');
    }

    // Relationship to Post
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function stars()
    {
        return $this->belongsToMany(Post::class, 'stars')->withTimestamps();
    }

    public function saves()
    {
        return $this->belongsToMany(Post::class, 'saves')->withTimestamps();
    }

    public function followers()
    {
        return $this->hasMany(Follower::class, 'following_id');
    }

    // Define the following relationship
    public function following()
    {
        return $this->hasMany(Follower::class, 'follower_id');
    }

    /**
     * Check if the user is following the specified user.
     *
     * @param User $user
     * @return bool
     */
    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    /**
     * Get the comments for the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Follow the specified user.
     *
     * @param User $user
     * @return void
     */
    public function follow(User $user)
    {
        if (!$this->isFollowing($user)) {
            $this->following()->create([
                'following_id' => $user->id,
            ]);
        }
    }

    /**
     * Unfollow the specified user.
     *
     * @param User $user
     * @return void
     */
    public function unfollow(User $user)
    {
        $this->following()->where('following_id', $user->id)->delete();
    }
}
