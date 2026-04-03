<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Widgets\ChartWidget;

class RevenueChartWidget extends ChartWidget
{
    // Heading non-static (sesuai Filament v4)
    protected ?string $heading = 'Pendapatan per Bulan';

    // Bikin widget lebih lebar di grid dashboard
    protected int|string|array $columnSpan = [
            'default' => 1,
            'lg' => 3,
    ];

    protected function getData(): array
    {
        // Ambil total_tagihan per bulan (hanya bulan yang punya data)
        $rows = Invoice::selectRaw('MONTH(tanggal) as bulan, SUM(total_tagihan) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan'); // key = nomor bulan 1–12

        // Nama-nama bulan
        $monthNames = [
            1  => 'Jan',
            2  => 'Feb',
            3  => 'Mar',
            4  => 'Apr',
            5  => 'Mei',
            6  => 'Jun',
            7  => 'Jul',
            8  => 'Agu',
            9  => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $labels = [];
        $values = [];

        // Paksa selalu 12 bulan, isi 0 jika tidak ada data
        for ($month = 1; $month <= 12; $month++) {
            $labels[] = $monthNames[$month];
            $values[] = $rows[$month]->total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $values,
                    'backgroundColor' => '#22c55e',
                    'borderColor' => '#22c55e',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // ganti 'line' jika mau grafik garis
    }
}
