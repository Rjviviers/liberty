<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'detail',
        'text',
        'is_approved',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include approved testimonials.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Get the status attribute.
     * Maps the is_approved boolean to a status string
     */
    public function getStatusAttribute()
    {
        if (array_key_exists('status', $this->attributes)) {
            return $this->attributes['status'];
        }
        return $this->is_approved ? 'approved' : 'pending';
    }

    /**
     * Set the status attribute.
     * Maps the status string to is_approved boolean
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
        $this->attributes['is_approved'] = ($value === 'approved');
    }
}
