<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    protected $fillable = [
        'ip_hash',
        'pays',
        'code_pays',
        'ville',
        'navigateur',
        'plateforme',
        'page_visitee',
        'article_id',
        'type_page',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function scopeAujourdhui($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeCetteSemaine($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeCeMois($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }

    public function scopeVisiteursUniques($query)
    {
        return $query->distinct('ip_hash');
    }
}
