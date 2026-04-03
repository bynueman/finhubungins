<?php

namespace App\Filament\Resources\Jasas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class JasaForm
{
    public static function make(): array
    {
        return [
            Section::make('Informasi Jasa')
                ->schema([
                    Select::make('invoice_id')
                        ->relationship('invoice', 'projek')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->label('Invoice'),
                    TextInput::make('nama_jasa')
                        ->required()
                        ->maxLength(255)
                        ->label('Nama Jasa'),
                    TextInput::make('biaya')
                        ->required()
                        ->numeric()
                        ->prefix('Rp')
                        ->label('Biaya'),
                    TextInput::make('qty')
                        ->required()
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->label('Quantity'),
                ])->columns(2),
        ];
    }
}
