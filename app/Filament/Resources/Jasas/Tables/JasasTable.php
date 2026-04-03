<?php

namespace App\Filament\Resources\Jasas\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables;

class JasasTable
{
    public static function columns(): array
    {
        return [
            Tables\Columns\TextColumn::make('invoice.projek')
                ->searchable()
                ->sortable()
                ->label('Invoice'),
            Tables\Columns\TextColumn::make('nama_jasa')
                ->searchable()
                ->label('Nama Jasa'),
            Tables\Columns\TextColumn::make('biaya')
                ->money('IDR')
                ->sortable()
                ->label('Biaya'),
            Tables\Columns\TextColumn::make('qty')
                ->numeric()
                ->sortable()
                ->label('Qty'),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime('d M Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function filters(): array
    {
        return [];
    }

    public static function actions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }

    public static function bulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }
}
