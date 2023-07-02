<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'model', 'type', 'description'
    ];

    /**
     * The hidden attributes.
     */
    protected $hidden = [
        'pivot'
    ];

    // Relations
    public function bikes(): BelongsToMany
    {
        return $this->belongsToMany(Bike::class, 'bike_items');
    }
}
