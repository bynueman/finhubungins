<?php

namespace App\Filament\Resources\Kliens;

use App\Filament\Resources\Kliens\Pages;
use App\Models\Klien;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class KlienResource extends Resource
{
    protected static ?string $model = Klien::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationLabel = 'Klien';
    
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema(
            Schemas\KlienForm::make()
        );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                Tables\KliensTable::columns()
            )
            ->filters(
                Tables\KliensTable::filters()
            )
            ->actions(
                Tables\KliensTable::actions()
            )
            ->bulkActions(
                Tables\KliensTable::bulkActions()
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKliens::route('/'),
            'create' => Pages\CreateKlien::route('/create'),
            'edit' => Pages\EditKlien::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
