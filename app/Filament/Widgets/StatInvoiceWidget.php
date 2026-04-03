<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatInvoiceWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Invoice', Invoice::count())
                ->description('Total semua invoice')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),

            Stat::make('Invoice Lunas', Invoice::where('status_pembayaran', 'lunas')->count())
                ->description('Sudah dibayar')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

Stat::make(
    'Invoice Belum Lunas',
    Invoice::whereIn('status_pembayaran', ['dp', 'belum_lunas'])->count()
)
                ->description('Belum dibayar')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
}
