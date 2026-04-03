<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Klien extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nama_instansi',
        'alamat',
        'no_telp',
        'email',
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
