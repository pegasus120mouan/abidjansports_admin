<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'parent_id',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function sousCategories()
    {
        return $this->hasMany(SousCategory::class, 'category_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function allParents()
    {
        return $this->parent()->with('allParents');
    }

    public function getFullPathAttribute()
    {
        $path = collect([$this->nom]);
        $parent = $this->parent;
        
        while ($parent) {
            $path->prepend($parent->nom);
            $parent = $parent->parent;
        }
        
        return $path->implode(' > ');
    }

    public function getDepthAttribute()
    {
        $depth = 0;
        $parent = $this->parent;
        
        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }
        
        return $depth;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->nom);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('nom') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->nom);
            }
        });
    }
}
