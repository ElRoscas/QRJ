<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrCode extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'qr_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuari_correu',
        'esdeveniment_id',
        'qr_code',
        'qr_code_path',
        'qr_sent',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'qr_sent' => 'boolean',
    ];

    /**
     * Get the user that owns the QR code.
     */
    public function usuari(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuari_correu', 'Correu');
    }

    /**
     * Get the event associated with the QR code.
     */
    public function esdeveniment(): BelongsTo
    {
        return $this->belongsTo(Esdeveniment::class, 'esdeveniment_id');
    }
}
