<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'klien_id',
        'projek',
        'tanggal',
        'jatuh_tempo_pembayaran',
        'tipe_invoice',
        'total_tagihan',
        'diskon',
        'jumlah_bayar',
        'kurang_bayar',
        'status_pembayaran',
        'metode_pembayaran',
        'bukti_dp',
        'bukti_lunas',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jatuh_tempo_pembayaran' => 'date',
        'total_tagihan' => 'decimal:2',
        'diskon' => 'decimal:2',
        'jumlah_bayar' => 'decimal:2',
        'kurang_bayar' => 'decimal:2',
    ];

    public function klien(): BelongsTo
    {
        return $this->belongsTo(Klien::class);
    }

    public function jasas(): HasMany
    {
        return $this->hasMany(Jasa::class);
    }
}
