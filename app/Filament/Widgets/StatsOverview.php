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

            Stat::make('Total Target', "10000")
                ->icon('heroicon-o-chart-pie'),

            Stat::make('Agen Terevaluasi', "90")
                ->icon('heroicon-o-check-circle'),

            Stat::make('Target Terevaluasi', "8900")
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
