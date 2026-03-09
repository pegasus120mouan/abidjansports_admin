<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Journal extends Model
{
    protected $fillable = [
        'titre',
        'slug',
        'description',
        'image',
        'fichier_pdf',
        'prix',
        'date_publication',
        'numero',
        'statut',
        'stock',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'date_publication' => 'date',
        'stock' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($journal) {
            if (empty($journal->slug)) {
                $journal->slug = Str::slug($journal->titre . '-' . $journal->numero);
            }
        });
    }

    public function scopeDisponible($query)
    {
        return $query->where('statut', 'disponible');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('date_publication', 'desc');
    }
}
