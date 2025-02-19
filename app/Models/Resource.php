<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resource extends Model
{
    /** @use HasFactory<\Database\Factories\ResourceFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'available'
    ];

    public function createdAt(): string
    {
        return Carbon::parse($this->created_at)->toDateString();

    }

    public function scopeAvailable($query)
    {
        return $query->where('available', true);
    }

    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
