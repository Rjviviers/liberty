<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteContent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'section',
        'key',
        'value',
        'type',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active content.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by section.
     */
    public function scopeSection($query, $section)
    {
        return $query->where('section', $section);
    }

    /**
     * Get value with proper casting based on type.
     */
    public function getProcessedValueAttribute()
    {
        if ($this->type === 'json') {
            return json_decode($this->value, true);
        }
        
        return $this->value;
    }
}
