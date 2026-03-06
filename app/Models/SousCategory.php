<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SousCategory extends Model
{
    use HasFactory;

    protected $table = 'sous_categories';

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'icone',
        'category_id',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sousCategory) {
            if (empty($sousCategory->slug)) {
                $sousCategory->slug = Str::slug($sousCategory->nom);
            }
        });

        static::updating(function ($sousCategory) {
            if ($sousCategory->isDirty('nom') && !$sousCategory->isDirty('slug')) {
                $sousCategory->slug = Str::slug($sousCategory->nom);
            }
        });
    }
}
