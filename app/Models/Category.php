<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the tools for the category.
     */
    public function tools() {
        return $this->hasMany(Tool::class);
    }

    /**
     * Get the consumables for the category.
     */
    public function consumables() {
        return $this->hasMany(Consumable::class);
    }
}
