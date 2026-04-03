<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'nama' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Generate 10 Clients
        \App\Models\Klien::factory(10)->create()->each(function ($klien) {
            // Each Client has 1-3 Invoices
            \App\Models\Invoice::factory(rand(1, 3))->create([
                'klien_id' => $klien->id,
            ])->each(function ($invoice) {
                // Each Invoice has 2-4 Service items
                \App\Models\Jasa::factory(rand(2, 4))->create([
                    'invoice_id' => $invoice->id,
                ]);
                
                // Recalculate invoice total based on items
                $total = $invoice->jasas->sum(function($jasa) {
                    return $jasa->biaya * $jasa->qty;
                });
                
                $diskon = rand(0, 50000);
                $invoice->update([
                    'total_tagihan' => $total,
                    'diskon' => $diskon,
                    'kurang_bayar' => ($total - $diskon) - $invoice->jumlah_bayar,
                ]);
            });
        });
    }
}
