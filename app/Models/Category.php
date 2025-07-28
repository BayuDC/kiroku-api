<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {
    use HasFactory, SoftDeletes;

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
     * Get the tools for the category including soft deleted ones.
     */
    public function toolsWithTrashed() {
        return $this->hasMany(Tool::class)->withTrashed();
    }

    /**
     * Get the consumables for the category.
     */
    public function consumables() {
        return $this->hasMany(Consumable::class);
    }

    /**
     * Get the consumables for the category including soft deleted ones.
     */
    public function consumablesWithTrashed() {
        return $this->hasMany(Consumable::class)->withTrashed();
    }
}
