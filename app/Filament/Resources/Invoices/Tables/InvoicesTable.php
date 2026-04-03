<?php

namespace App\Filament\Resources\Invoices\Tables;

use Filament\Tables;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Actions\BulkAction;

class InvoicesTable
{
    public static function columns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label('No. Invoice')
                ->sortable()
                ->formatStateUsing(fn ($state) => '#INV-' . str_pad($state, 4, '0', STR_PAD_LEFT)),
            Tables\Columns\TextColumn::make('klien.nama')
                ->searchable()
                ->sortable()
                ->label('Klien'),
            Tables\Columns\TextColumn::make('projek')
                ->searchable()
                ->label('Projek')
                ->wrap(),
            Tables\Columns\TextColumn::make('tanggal')
                ->date('d M Y')
                ->sortable()
                ->label('Tanggal'),
            Tables\Columns\TextColumn::make('kurang_bayar')
                ->money('IDR')
                ->sortable()
                ->label('Kurang'),
            Tables\Columns\TextColumn::make('total_tagihan')
                ->money('IDR')
                ->sortable()
                ->label('Total'),
            Tables\Columns\TextColumn::make('status_pembayaran')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'belum_lunas' => 'danger',
                    'dp' => 'warning',
                    'lunas' => 'success',
                })
                ->label('Status')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'belum_lunas' => 'Belum Lunas',
                    'dp' => 'DP',
                    'lunas' => 'Lunas',
                }),
            Tables\Columns\TextColumn::make('tipe_invoice')
                ->badge()
                ->label('Tipe')
                ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\ImageColumn::make('bukti_dp')
    ->label('Bukti DP')
    ->disk('public')
    ->size(40),

Tables\Columns\ImageColumn::make('bukti_lunas')
    ->label('Bukti Lunas')
    ->disk('public')
    ->size(40),

        ];
    }

    public static function filters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('status_pembayaran')
                ->options([
                    'belum_lunas' => 'Belum Lunas',
                    'dp' => 'DP',
                    'lunas' => 'Lunas',
                ])
                ->label('Status'),
            Tables\Filters\SelectFilter::make('tipe_invoice')
                ->options([
                    'simple' => 'Simple',
                    'detail' => 'Detail',
                ])
                ->label('Tipe'),
        ];
    }

    public static function actions(): array
{
return [
        EditAction::make(),
    ];
}


public static function bulkActions(): array
{
    return [
        DeleteBulkAction::make(),

        BulkAction::make('view_pdf')
            ->label('View PDF')
            ->icon('heroicon-o-eye')
            ->color('secondary')
            ->action(function ($records) {
                // Contoh: hanya ambil invoice pertama yang diceklis untuk preview
                $firstId = $records->first()?->id;
                if ($firstId) {
                    return redirect()->route('invoice.pdf.preview', ['id' => $firstId]);
                }
                return;
            })
            ->requiresConfirmation()
            ->modalHeading('View Invoice PDF')
            ->modalDescription('Lihat PDF invoice terpilih (hanya invoice pertama yang diceklis).')
            ->modalSubmitActionLabel('View'),

        BulkAction::make('download_pdf')
            ->label('Download PDF')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('primary')
            ->action(function ($records) {
                // Contoh: download invoice ID pertama yang diceklis
                $firstId = $records->first()?->id;
                if ($firstId) {
                    return redirect()->route('invoice.pdf.download', ['id' => $firstId]);
                }
                return;
            })
            ->requiresConfirmation()
            ->modalHeading('Download Invoice PDF')
            ->modalDescription('Download PDF invoice terpilih (hanya invoice pertama yang diceklis).')
            ->modalSubmitActionLabel('Download'),

        BulkAction::make('download_bulk_pdf')
            ->label('Download ZIP')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('warning')
            ->action(function ($records) {
                $ids = $records->pluck('id')->implode(',');
                return redirect()->route('invoice.bulk.download', ['ids' => $ids]);
            })
            ->requiresConfirmation()
            ->modalHeading('Download ZIP')
            ->modalDescription('Download semua invoice terpilih sebagai ZIP')
            ->modalSubmitActionLabel('Download ZIP')
    ];
}
}