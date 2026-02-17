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
        'capacitat_max_acompanyants',
        'validar_capacitat',
        'max_qrs_per_usuari',
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
        'capacitat_max_acompanyants' => 'integer',
        'validar_capacitat' => 'boolean',
        'max_qrs_per_usuari' => 'integer',
    ];

    /**
     * Relación con el modelo User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'ID_USER', 'Correu');
    }

    /**
     * Relación con assistents
     */
    public function assistents()
    {
        return $this->hasMany(EsdevenimentAssistent::class, 'esdeveniment_id');
    }

    /**
     * Relación con códigos QR
     */
    public function qrCodes()
    {
        return $this->hasMany(QrCode::class, 'esdeveniment_id');
    }

    /**
     * Total de acompañantes confirmados
     */
    public function getTotalAcompanyantsAttribute()
    {
        return $this->assistents()->sum('num_acompanyants_confirmats');
    }

    /**
     * Verificar si hay capacidad disponible
     */
    public function teCapacitatDisponible($numAcompanyants = 0)
    {
        if (!$this->validar_capacitat) {
            return true;
        }

        $totalActual = $this->getTotalAcompanyantsAttribute();
        return ($totalActual + $numAcompanyants) <= $this->Nº_Invitats;
    }
}
