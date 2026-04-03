<?php

namespace App\Filament\Resources\Jasas;

use App\Filament\Resources\Jasas\Pages;
use App\Models\Jasa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class JasaResource extends Resource
{
    protected static ?string $model = Jasa::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';
    
    protected static ?string $navigationLabel = 'Jasa';
    
    protected static ?int $navigationSort = 3;
    
    protected static bool $shouldRegisterNavigation = false;  // ← TAMBAHKAN INI (Hide dari menu)

    public static function form(Schema $schema): Schema
    {
        return $schema->schema(
            Schemas\JasaForm::make()
        );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                Tables\JasasTable::columns()
            )
            ->filters(
                Tables\JasasTable::filters()
            )
            ->actions(
                Tables\JasasTable::actions()
            )
            ->bulkActions(
                Tables\JasasTable::bulkActions()
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJasas::route('/'),
            'create' => Pages\CreateJasa::route('/create'),
            'edit' => Pages\EditJasa::route('/{record}/edit'),
        ];
    }
}
