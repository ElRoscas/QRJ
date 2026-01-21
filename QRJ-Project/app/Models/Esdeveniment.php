<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esdeveniment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'esdeveniments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'ID_USER',
        'Nom',
        'Descripcio',
        'Nº_Invitats',
        'Nº_VIPS',
        'Tipus',
        'Ubicacio',
        'Data_Esdeveniment',
        'Hora_Inici',
        'Data_Limit_Confirmacio',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'Data_Esdeveniment' => 'date',
        'Hora_Inici' => 'datetime:H:i',
        'Data_Limit_Confirmacio' => 'date',
        'Nº_Invitats' => 'integer',
        'Nº_VIPS' => 'integer',
    ];

    /**
     * Relación con el modelo User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'ID_USER', 'Correu');
    }
}
