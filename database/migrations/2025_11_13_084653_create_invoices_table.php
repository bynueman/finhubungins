<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klien_id')->constrained('kliens')->onDelete('cascade');
            $table->string('projek');
            $table->date('tanggal');
            $table->date('jatuh_tempo_pembayaran')->nullable();
            $table->enum('tipe_invoice', ['detail', 'simple'])->default('simple');
            $table->decimal('total_tagihan', 15, 2)->default(0);
            $table->decimal('diskon', 15, 2)->default(0);
            $table->decimal('jumlah_bayar', 15, 2)->default(0);
            $table->decimal('kurang_bayar', 15, 2)->default(0);
            $table->enum('status_pembayaran', ['belum_lunas', 'dp', 'lunas'])->default('belum_lunas');
            $table->string('metode_pembayaran')->nullable();
            $table->string('bukti_dp')->nullable();
            $table->string('bukti_lunas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
