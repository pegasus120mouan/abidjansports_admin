<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'slug',
        'contenu',
        'resume',
        'image',
        'sous_category_id',
        'user_id',
        'statut',
        'date_publication',
        'vues',
    ];

    protected $casts = [
        'date_publication' => 'datetime',
    ];

    public function sousCategory()
    {
        return $this->belongsTo(SousCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->sousCategory->category ?? null;
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        $disk = config('filesystems.default');
        
        if ($disk === 's3') {
            return route('storage.proxy', ['path' => $this->image]);
        }
        
        return asset('storage/' . $this->image);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->titre);
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('titre') && !$article->isDirty('slug')) {
                $article->slug = Str::slug($article->titre);
            }
        });
    }
}
