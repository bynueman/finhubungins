<?php

namespace App\Filament\Resources\Kliens\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables;

class KliensTable
{
    public static function columns(): array
    {
        return [
            Tables\Columns\TextColumn::make('nama')
                ->searchable()
                ->sortable()
                ->label('Nama Klien'),
            Tables\Columns\TextColumn::make('nama_instansi')
                ->searchable()
                ->label('Instansi'),
            Tables\Columns\TextColumn::make('no_telp')
                ->searchable()
                ->label('Telepon'),
            Tables\Columns\TextColumn::make('email')
                ->searchable()
                ->label('Email'),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime('d M Y')
                ->sortable()
                ->label('Dibuat')
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
        ];
    }

    public static function bulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }
}
