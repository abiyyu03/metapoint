<?php

namespace App\Filament\Widgets;

use App\Models\Agent;
use App\Models\AssessmentResult\AssessmentResult;
use App\Models\Target;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static bool $isLazy = false;
    protected function getStats(): array
    {
        $targets = Target::count();
        $agents = Agent::count();
        $assessmentResult = AssessmentResult::count();
        $user = User::count();
        return [
            Stat::make('Total Agen', $targets)
                ->icon('heroicon-o-user-group'),

            Stat::make('Total Target',  $agents)
                ->icon('heroicon-o-chart-pie'),

            Stat::make('Evaluasi Target', $assessmentResult)
                ->icon('heroicon-o-check-circle'),

            Stat::make('Akun pengguna aktif', $user)
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
