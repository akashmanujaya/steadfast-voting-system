<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Define the fillable fields for the item
    protected $fillable = ['name', 'icon'];

    /**
     * Get the votes for the item.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

}
