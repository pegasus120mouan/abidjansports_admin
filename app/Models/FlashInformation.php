<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashInformation extends Model
{
    use HasFactory;

    protected $table = 'flash_informations';

    protected $fillable = [
        'titre',
        'contenu',
        'icone',
        'actif',
        'user_id',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }
}
