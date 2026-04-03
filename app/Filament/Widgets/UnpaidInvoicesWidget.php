<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class UnpaidInvoicesWidget extends BaseWidget
{
    protected static ?string $heading = 'Invoice Belum Lunas';

    protected int|string|array $columnSpan = [
        'default' => 2,
        'lg' => 3,
    ];

    protected function getTableQuery(): Builder
    {
        return Invoice::query()
            ->where('status_pembayaran', 'belum_lunas')
            ->latest('tanggal');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label('No.')
                ->sortable(),

            Tables\Columns\TextColumn::make('projek')
                ->label('Projek')
                ->searchable(),

            Tables\Columns\TextColumn::make('tanggal')
                ->label('Tanggal')
                ->date('d M Y')
                ->sortable(),

            Tables\Columns\TextColumn::make('total_tagihan')
                ->label('Total')
                ->formatStateUsing(fn ($state) => 'Rp '.number_format($state, 0, ',', '.')),
        ];
    }
}
