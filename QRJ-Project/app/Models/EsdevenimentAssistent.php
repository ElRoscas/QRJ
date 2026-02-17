<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EsdevenimentAssistent extends Model
{
    use HasFactory;

    protected $table = 'esdeveniment_assistents';

    protected $fillable = [
        'esdeveniment_id',
        'usuari_correu',
        'num_acompanyants_permesos',
        'num_acompanyants_confirmats',
        'confirmat',
        'data_confirmacio',
    ];

    protected $casts = [
        'confirmat' => 'boolean',
        'data_confirmacio' => 'datetime',
        'num_acompanyants_permesos' => 'integer',
        'num_acompanyants_confirmats' => 'integer',
    ];

    /**
     * Relación con esdeveniment
     */
    public function esdeveniment()
    {
        return $this->belongsTo(Esdeveniment::class, 'esdeveniment_id');
    }

    /**
     * Relación con usuari
     */
    public function usuari()
    {
        return $this->belongsTo(User::class, 'usuari_correu', 'Correu');
    }
}
