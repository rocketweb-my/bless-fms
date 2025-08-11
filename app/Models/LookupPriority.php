<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LookupPriority extends Model
{
    use HasFactory;

    protected $table = 'lookup_priority';
    
    protected $fillable = [
        'priority_value',
        'name_en',
        'name_ms',
        'duration_days',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get priority name based on current locale
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ms' ? $this->name_ms : $this->name_en;
    }

    /**
     * Scope to get active priorities only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get priority by value
     */
    public static function getByValue($value)
    {
        return static::where('priority_value', $value)->active()->first();
    }
}
