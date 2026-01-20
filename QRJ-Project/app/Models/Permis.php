<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permis extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissos';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ID_Permissos';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ID_Usuari',
        'PermCode',
    ];

    /**
     * Relación con la tabla usuari
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'ID_Usuari', 'Correu');
    }
}
