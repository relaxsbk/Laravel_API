<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    protected $fillable = [
        'resource_id',
        'user_id',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function createdAt(): string
    {
        return Carbon::parse($this->created_at)->toDateString();
    }

    public function updatedAt(): string
    {
        return Carbon::parse($this->updated_at)->toDateString();
    }

    public function startTime(): string
    {
        return Carbon::parse($this->start_time)->toDateTimeString();
    }

    public function endTime(): string
    {
        return Carbon::parse($this->end_time)->toDateTimeString();
    }

    public function scopeIsOverLapping($query, $startTime, $endTime)
    {
        return $query->where(function ($query) use ($startTime, $endTime) {
            $query->whereBetween('start_time', [$startTime, $endTime])
                ->orWhereBetween('end_time', [$startTime, $endTime])
                ->orWhere(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<=', $endTime)
                        ->where('end_time', '>=', $endTime);
                });
        });
    }

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
