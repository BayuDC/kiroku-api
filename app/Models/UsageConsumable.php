<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageConsumable extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usage_id',
        'consumable_id',
        'quantity',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Get the usage that owns the usage consumable.
     */
    public function usage() {
        return $this->belongsTo(Usage::class);
    }

    /**
     * Get the consumable that is part of the usage.
     */
    public function consumable() {
        return $this->belongsTo(Consumable::class);
    }
}
