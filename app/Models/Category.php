<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // Deze velden mag Filament invullen
    protected $fillable = ['name', 'slug'];

    // Een categorie heeft meerdere producten
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}