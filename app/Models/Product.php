<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute; // Vergeet deze import niet!

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 
        'image', 'bonus_percentage', 'is_featured', 'category_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // --- VOEG DIT STUKJE TOE ---
    // protected function image(): Attribute
    // {
    //     return Attribute::make(
    //         get: function ($value) {
    //             if (!$value) return null;
    //             // Als het al een volledige URL is (bijv. van internet), geef die terug
    //             if (filter_var($value, FILTER_VALIDATE_URL)) return $value;
    //             // Anders plakken we er netjes /storage/ voor
    //             return asset('storage/' . $value);
    //         }
    //     );
    // }
}