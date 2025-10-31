<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static bool $isLazy = false;
    protected function getStats(): array
    {
        return [
            Stat::make('Total Agen', "100")
                ->icon('heroicon-o-user-group'),

            Stat::make('Total Target', "1000")
                ->icon('heroicon-o-chart-pie'),

            Stat::make('Evaluasi Target', "90")
                ->icon('heroicon-o-check-circle'),

            Stat::make('Akun pengguna aktif', "70")
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
