<?php

namespace App\Filament\Resources\FinancialReports\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FinancialReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->label('Tanggal Transaksi')
                    ->default(now())
                    ->required(),

                Select::make('type')
                    ->label('Jenis Transaksi')
                    ->options([
                        'income' => '📥 Pemasukan (Uang Masuk / Infaq)',
                        'expense' => '📤 Pengeluaran (Uang Keluar / Biaya)',
                    ])
                    ->native(false)
                    ->required(),

                Select::make('category')
                    ->label('Kategori Kas')
                    ->options([
                        'Operasional' => '🕌 Kas Operasional Masjid',
                        'Pembangunan' => '🏗️ Kas Pembangunan Masjid',
                        'Anak Yatim'  => '👶 Kas Anak Yatim',
                    ])
                    ->default('Operasional')
                    ->native(false)
                    ->required(),

                TextInput::make('amount')
                    ->label('Jumlah Uang (Rp)')
                    ->prefix('Rp')
                    ->numeric()
                    ->placeholder('Contoh: 500000')
                    ->required(),

                TextInput::make('description')
                    ->label('Keterangan Transaksi')
                    ->placeholder('Contoh: Infaq Salat Jumat / Pembelian Karpet')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }
}