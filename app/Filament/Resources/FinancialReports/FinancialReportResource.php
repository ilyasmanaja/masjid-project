<?php

namespace App\Filament\Resources\FinancialReports;

use App\Filament\Resources\FinancialReports\Pages\CreateFinancialReport;
use App\Filament\Resources\FinancialReports\Pages\EditFinancialReport;
use App\Filament\Resources\FinancialReports\Pages\ListFinancialReports;
use App\Filament\Resources\FinancialReports\Schemas\FinancialReportForm;
use App\Filament\Resources\FinancialReports\Tables\FinancialReportsTable;
use App\Models\FinancialReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FinancialReportResource extends Resource
{
    protected static ?string $model = FinancialReport::class;

    // 1. Ganti Ikon ke Ikon Uang (Banknotes)
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    // 2. Ganti Label Menu Sidebar dan Judul Halaman ke Bahasa Indonesia yang Ramah
    protected static ?string $navigationLabel = 'Pencatatan Kas (Infaq)';
    protected static ?string $modelLabel = 'Transaksi Kas';
    protected static ?string $pluralModelLabel = 'Laporan Kas Keuangan';

    // 3. Atur Urutan Menu di Sidebar (Angka 2 = Di bawah Data Pengurus)
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return FinancialReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FinancialReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFinancialReports::route('/'),
            'create' => CreateFinancialReport::route('/create'),
            'edit' => EditFinancialReport::route('/{record}/edit'),
        ];
    }
}