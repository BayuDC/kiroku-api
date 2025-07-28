<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanTool extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'loan_id',
        'tool_id',
        'condition_before',
        'condition_after',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'condition_before' => 'string',
        'condition_after' => 'string',
    ];

    /**
     * Get the loan that owns the loan tool.
     */
    public function loan() {
        return $this->belongsTo(Loan::class);
    }

    /**
     * Get the tool that is part of the loan.
     */
    public function tool() {
        return $this->belongsTo(Tool::class);
    }

    /**
     * Check if the tool condition has changed after return.
     */
    public function hasConditionChanged() {
        return $this->condition_before !== $this->condition_after;
    }

    /**
     * Check if the tool has been returned.
     */
    public function isReturned() {
        return !is_null($this->condition_after);
    }
}
