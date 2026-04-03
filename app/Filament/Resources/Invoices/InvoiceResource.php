<?php

namespace App\Filament\Resources\Invoices;

use App\Filament\Resources\Invoices\Pages;
use App\Models\Invoice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Invoice';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema(
            Schemas\InvoiceForm::make()
        );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                Tables\InvoicesTable::columns()
            )
            ->filters([
    Filter::make('periode')
        ->label('Filter Bulan & Tahun')
        ->form([
            Forms\Components\Select::make('bulan')
                ->label('Pilih Bulan')
                ->options([
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                ]),
            Forms\Components\Select::make('tahun')
                ->label('Pilih Tahun')
                ->options([
                    2025 => '2025',
                    // Tambah tahun sesuai kebutuhan, bisa dinamis juga dari database
                ]),
        ])
        ->query(function (Builder $query, array $data) {
            if ($data['bulan']) {
                $query->whereMonth('tanggal', $data['bulan']);
            }
            if ($data['tahun']) {
                $query->whereYear('tanggal', $data['tahun']);
            }
        }),
])
            ->actions(
                Tables\InvoicesTable::actions()
            )
            ->bulkActions(
                Tables\InvoicesTable::bulkActions()
            )
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
