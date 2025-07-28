<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usage extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'used_by',
        'date',
        'staff_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Get the staff member that recorded the usage.
     */
    public function staff() {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Get the consumables included in this usage.
     */
    public function consumables() {
        return $this->belongsToMany(Consumable::class, 'usage_consumables')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Get the total quantity of all consumables used.
     */
    public function getTotalQuantityAttribute() {
        return $this->consumables->sum('pivot.quantity');
    }
}
