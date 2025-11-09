<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\MapClusteringTargetAgent;
use App\Filament\Widgets\Maps;
use App\Filament\Widgets\TargetBehaviorChart;
use App\Filament\Widgets\TopOrganizationsChart;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use Filament\Widgets\AccountWidget;

class Dashboard extends BaseDashboard
{
    // **match parent exactly**
    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            TopOrganizationsChart::class,
            TargetBehaviorChart::class,
        ];
    }
}
