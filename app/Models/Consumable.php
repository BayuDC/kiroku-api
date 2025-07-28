<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumable extends Model {
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category_id',
        'stock',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'stock' => 'integer',
    ];

    /**
     * Get the category that owns the consumable.
     */
    public function category() {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    /**
     * Get the usages that include this consumable.
     */
    public function usages() {
        return $this->belongsToMany(Usage::class, 'usage_consumables')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
