<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;

    protected $table = "custom_fields";
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * Get custom fields that are suitable for filtering
     */
    public static function getFilterableFields()
    {
        return self::whereIn('use', ['1', '2']) // Public or staff only
            ->whereIn('type', ['radio', 'select', 'checkbox'])
            ->whereNotNull('value')
            ->orderBy('order')
            ->get();
    }

    /**
     * Get field options from JSON value
     */
    public function getOptionsAttribute()
    {
        if (!$this->value) return [];
        
        $value = json_decode($this->value, true);
        
        switch ($this->type) {
            case 'radio':
                return $value['radio_options'] ?? [];
            case 'select':
                return $value['select_options'] ?? [];
            case 'checkbox':
                return $value['checkbox_options'] ?? [];
            default:
                return [];
        }
    }

    /**
     * Get field name in current locale
     */
    public function getLocalizedNameAttribute()
    {
        if (!$this->name) return 'Custom Field ' . $this->id;
        
        $names = json_decode($this->name, true);
        $locale = app()->getLocale();
        
        // Try current locale first, then English, then first available
        return $names[$locale] ?? $names['English'] ?? $names['en'] ?? array_values($names)[0] ?? 'Custom Field ' . $this->id;
    }

    /**
     * Check if field is filterable
     */
    public function isFilterable()
    {
        return in_array($this->use, ['1', '2']) && 
               in_array($this->type, ['radio', 'select', 'checkbox']) && 
               !empty($this->options);
    }
}
