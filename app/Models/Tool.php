<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category_id',
        'status',
        'condition',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'string',
        'condition' => 'string',
    ];

    /**
     * Get the category that owns the tool.
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the loans that include this tool.
     */
    public function loans() {
        return $this->belongsToMany(Loan::class, 'loan_tools')
            ->withPivot('condition_before', 'condition_after')
            ->withTimestamps();
    }
}
