<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jasa extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'nama_jasa',
        'biaya',
        'qty',
    ];

    protected $casts = [
        'biaya' => 'decimal:2',
        'qty' => 'integer',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
