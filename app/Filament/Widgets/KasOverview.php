<?php

namespace App\Filament\Widgets;

use App\Models\FinancialReport;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KasOverview extends BaseWidget
{
    // Memastikan widget berada paling atas di Dashboard
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // 1. Hitung Saldo Kas Operasional
        $kasOperasional = FinancialReport::where('category', 'Operasional')->where('type', 'income')->sum('amount')
                        - FinancialReport::where('category', 'Operasional')->where('type', 'expense')->sum('amount');

        // 2. Hitung Saldo Kas Pembangunan
        $kasPembangunan = FinancialReport::where('category', 'Pembangunan')->where('type', 'income')->sum('amount')
                        - FinancialReport::where('category', 'Pembangunan')->where('type', 'expense')->sum('amount');

        // 3. Hitung Saldo Kas Anak Yatim
        $kasYatim       = FinancialReport::where('category', 'Anak Yatim')->where('type', 'income')->sum('amount')
                        - FinancialReport::where('category', 'Anak Yatim')->where('type', 'expense')->sum('amount');

        return [
            Stat::make('🕌 Kas Operasional', 'Rp ' . number_format($kasOperasional, 0, ',', '.'))
                ->description('Listrik, kebersihan & harian')
                ->color('success'),

            Stat::make('🏗️ Kas Pembangunan', 'Rp ' . number_format($kasPembangunan, 0, ',', '.'))
                ->description('Renovasi & fisik masjid')
                ->color('warning'),

            Stat::make('👶 Kas Anak Yatim', 'Rp ' . number_format($kasYatim, 0, ',', '.'))
                ->description('Santunan rutin')
                ->color('info'),
        ];
    }
}