<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Klien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['belum_lunas', 'dp', 'lunas']);
        $total = $this->faker->randomFloat(2, 500000, 5000000);
        $diskon = $this->faker->randomFloat(2, 0, 100000);
        $jumlah_bayar = 0;

        if ($status === 'lunas') {
            $jumlah_bayar = $total - $diskon;
        } elseif ($status === 'dp') {
            $jumlah_bayar = ($total - $diskon) * 0.5;
        }

        return [
            'klien_id' => Klien::factory(),
            'projek' => $this->faker->sentence(3),
            'tanggal' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'jatuh_tempo_pembayaran' => $this->faker->dateTimeBetween('now', '+1 month'),
            'tipe_invoice' => $this->faker->randomElement(['detail', 'simple']),
            'total_tagihan' => $total,
            'diskon' => $diskon,
            'jumlah_bayar' => $jumlah_bayar,
            'kurang_bayar' => ($total - $diskon) - $jumlah_bayar,
            'status_pembayaran' => $status,
            'metode_pembayaran' => $this->faker->randomElement(['Transfer Bank', 'Tunai', 'QRIS']),
        ];
    }
}
