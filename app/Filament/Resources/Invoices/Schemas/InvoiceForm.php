<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Enums\JasaType;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;


class InvoiceForm
{
    public static function make(): array
    {
        return [
            Section::make('Informasi Klien & Projek')
                ->schema([
                    Select::make('klien_id')
                        ->relationship('klien', 'nama')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label('Klien')
                        ->createOptionForm([
                            TextInput::make('nama')->required()->label('Nama Klien'),
                            TextInput::make('nama_instansi')->label('Nama Instansi'),
                            Textarea::make('alamat')->rows(2)->label('Alamat'),
                            TextInput::make('no_telp')->required()->label('No. Telepon'),
                            TextInput::make('email')->email()->label('Email'),
                        ])
                        ->columnSpan(2),
                    TextInput::make('projek')
                        ->required()
                        ->maxLength(255)
                        ->label('Nama Projek')
                        ->columnSpan(2),
                    DatePicker::make('tanggal')
                    ->required()
                    ->default(now())
                    ->label('Tanggal Invoice')
                    ->maxDate(now()->toDateString()),
                    DatePicker::make('jatuh_tempo_pembayaran')
                        ->label('Jatuh Tempo')
                        ->default(now())
                        ,
                ])->columns(2),

            Section::make('Tipe Invoice')
                ->schema([
                    ToggleButtons::make('tipe_invoice')
                        ->options([
                            'simple' => 'Simple',
                            'detail' => 'Detail',
                        ])
                        ->icons([
                            'simple' => 'heroicon-o-document',
                            'detail' => 'heroicon-o-queue-list',
                        ])
                        ->default('simple')
                        ->inline()
                        ->required()
                        ->live()
                        ->label('Pilih Tipe Invoice'),
                ]),

            Section::make('Detail Item Jasa')
                ->schema([
                    Repeater::make('jasas')
                        ->relationship()
                        ->schema([
                            Select::make('nama_jasa')
                            ->label('Jasa')
                            ->options(JasaType::toArray())  // ← Pakai method toArray()
                            ->searchable()
                            ->required()
                            ->native(false)
                            ->columnSpan(2),
                            TextInput::make('qty')
                                ->numeric()
                                ->default(1)
                                ->required()
                                ->minValue(1)
                                ->label('Qty')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    self::updateTotals($get, $set);
                                }),
                            TextInput::make('biaya')
                                ->numeric()
                                ->required()
                                ->prefix('Rp')
                                ->label('Harga')
                                ->placeholder('Input harga')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    self::updateTotals($get, $set);
                                }),
                        ])
                        ->columns(4)
                        ->defaultItems(1)
                        ->addActionLabel('+ Tambah Item')
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::updateTotals($get, $set);
                        })
                        ->deleteAction(
                            fn ($action) => $action->after(fn (Get $get, Set $set) => self::updateTotals($get, $set)),
                        )
                        ->collapsible()
                        ->cloneable(),
                ])
                ->visible(fn (Get $get) => $get('tipe_invoice') === 'detail'),

            Section::make('Pembayaran')
                ->schema([
                    TextInput::make('total_tagihan')
                        ->numeric()
                        ->required()
                        ->prefix('Rp')
                        ->readOnly(fn (Get $get) => $get('tipe_invoice') === 'detail')
                        ->label('Total Tagihan')
                        ->live(onBlur: true),
                    TextInput::make('diskon')
                        ->numeric()
                        ->default(0)
                        ->prefix('Rp')
                        ->label('Diskon')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::updateKurangBayar($get, $set);
                        }),
                    TextInput::make('jumlah_bayar')
                        ->numeric()
                        ->default(0)
                        ->prefix('Rp')
                        ->label('Jumlah Dibayar')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::updateKurangBayar($get, $set);
                        }),
                    TextInput::make('kurang_bayar')
                        ->numeric()
                        ->prefix('Rp')
                        ->readOnly()
                        ->default(0)
                        ->label('Kurang Bayar'),
                    Select::make('status_pembayaran')
                        ->options([
                            'belum_lunas' => 'Belum Lunas',
                            'dp' => 'DP',
                            'lunas' => 'Lunas',
                        ])
                        ->default('belum_lunas')
                        ->required()
                        ->label('Status Pembayaran'),
                    TextInput::make('metode_pembayaran')
                        ->maxLength(255)
                        ->label('Metode Pembayaran')
                        ->placeholder('Transfer Bank, Cash, dll'),
                ])->columns(2),

            Section::make('Bukti Pembayaran')
                ->schema([
            FileUpload::make('bukti_dp')
                ->label('Bukti DP')
                ->disk('public')
                ->directory('bukti-pembayaran')
                ->preserveFilenames()
                ->image()
                ->maxSize(2048),


            FileUpload::make('bukti_lunas')
                ->label('Bukti Lunas')
                ->disk('public')
                ->directory('bukti-pembayaran')
                ->preserveFilenames()
                ->image()
                ->maxSize(2048),

                ])->columns(2)->collapsible(),
        ];
    }

    protected static function updateTotals(Get $get, Set $set): void
    {
        $jasas = collect($get('jasas') ?? []);
        $total = $jasas->reduce(function ($carry, $item) {
            return $carry + ((float) ($item['biaya'] ?? 0) * (int) ($item['qty'] ?? 1));
        }, 0);
        
        $set('total_tagihan', number_format($total, 2, '.', ''));
        self::updateKurangBayar($get, $set);
    }

    protected static function updateKurangBayar(Get $get, Set $set): void
    {
        $total = (float) ($get('total_tagihan') ?? 0);
        $diskon = (float) ($get('diskon') ?? 0);
        $bayar = (float) ($get('jumlah_bayar') ?? 0);
        
        $kurang = $total - $diskon - $bayar;
        $set('kurang_bayar', number_format(max(0, $kurang), 2, '.', ''));
    }
}
