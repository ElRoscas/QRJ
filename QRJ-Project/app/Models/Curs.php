<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curs extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'nombre',
        'nivel',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
    ];

    /**
     * Relación con usuaris
     */
    public function usuaris()
    {
        return $this->hasMany(User::class, 'curs_id');
    }

    /**
     * Scope para obtener solo cursos activos ordenados
     */
    public function scopeActius($query)
    {
        return $query->where('activo', true)->orderBy('orden');
    }
}
