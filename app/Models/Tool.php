<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tool extends Model {
    use HasFactory, SoftDeletes;

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
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'available',
    ];

    /**
     * Get the category that owns the tool.
     */
    public function category() {
        return $this->belongsTo(Category::class)->withTrashed();
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
