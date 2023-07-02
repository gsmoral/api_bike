<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bike extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'description', 'price', 'manufacturer'
    ];

    /**
     * The hidden attributes.
     */
    protected $hidden = [
        'pivot'
    ];

    // Relations
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'bike_items');
    }
}
