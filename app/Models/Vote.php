<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    // Define the fillable fields for the vote
    protected $fillable = ['user_id', 'item_id', 'ip_address', 'location'];

    /**
     * Get the user that owns the vote.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the item that was voted on.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
