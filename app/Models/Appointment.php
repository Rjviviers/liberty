<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'date',
        'time',
        'service',
        'message',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];

    /**
     * Get the patient that owns the appointment.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the status options.
     *
     * @return array
     */
    public static function getStatusOptions(): array
    {
        return [
            'scheduled' => 'Scheduled',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'no-show' => 'No-Show',
        ];
    }
}
