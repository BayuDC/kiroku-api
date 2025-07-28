<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'used_by',
        'loan_date',
        'return_date',
        'staff_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'loan_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    /**
     * Get the staff member that handled the loan.
     */
    public function staff() {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Get the tools included in this loan.
     */
    public function tools() {
        return $this->belongsToMany(Tool::class, 'loan_tools')
            ->withPivot('condition_before', 'condition_after')
            ->withTimestamps();
    }

    /**
     * Check if the loan is currently active (not returned).
     */
    public function isActive() {
        return is_null($this->return_date);
    }

    /**
     * Scope a query to only include active loans.
     */
    public function scopeActive($query) {
        return $query->whereNull('return_date');
    }

    /**
     * Scope a query to only include returned loans.
     */
    public function scopeReturned($query) {
        return $query->whereNotNull('return_date');
    }
}
