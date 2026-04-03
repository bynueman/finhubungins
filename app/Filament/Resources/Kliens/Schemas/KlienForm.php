<?php

namespace App\Filament\Resources\Kliens\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;

class KlienForm
{
    public static function make(): array
    {
        return [
            Section::make('Informasi Klien')
                ->schema([
                    TextInput::make('nama')
                        ->required()
                        ->maxLength(255)
                        ->label('Nama Klien'),
                    TextInput::make('nama_instansi')
                        ->maxLength(255)
                        ->label('Nama Instansi'),
                    Textarea::make('alamat')
                        ->rows(3)
                        ->columnSpanFull()
                        ->label('Alamat'),
                    TextInput::make('no_telp')
                        ->tel()
                        ->required()
                        ->maxLength(255)
                        ->label('No. Telepon'),
                    TextInput::make('email')
                        ->email()
                        ->maxLength(255)
                        ->label('Email'),
                ])->columns(2),
        ];
    }
}
