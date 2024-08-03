<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'followers';

    // Mass assignable attributes
    protected $fillable = ['follower_id', 'following_id'];

    // Define the relationship between Follower and User for the follower
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    // Define the relationship between Follower and User for the following
    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }
}
