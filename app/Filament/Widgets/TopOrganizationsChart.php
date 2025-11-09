<?php

namespace App\Filament\Widgets;

use App\Models\Organization;
use App\Models\Target;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TopOrganizationsChart extends ChartWidget
{
    protected ?string $heading = 'Jumlah Anggota Kelompok Terbanyak';
    protected ?string $maxHeight = '150px';
    protected int | string | array $columnSpan = 1;
    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $topOrganizations = Target::query()
            ->select('organization_id', DB::raw('COUNT(*) as total_members'))
            ->groupBy('organization_id')
            ->orderByDesc('total_members')
            ->limit(5)
            ->get();

        $organizationIds = $topOrganizations->pluck('organization_id')->toArray();
        $memberCounts = $topOrganizations->pluck('total_members')->toArray();

        $organizationNames = Organization::whereIn('id', $organizationIds)
            ->pluck('name', 'id')
            ->toArray();

        $labels = [];
        foreach ($topOrganizations as $org) {
            $labels[] = $organizationNames[$org->organization_id] ?? 'Organisasi ID: ' . $org->organization_id;
        }

        $colors = [
            '#EF4444',
            '#FFA550',
            '#FCD34D',
            '#34D399',
            '#60A5FA',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Anggota',
                    'data' => $memberCounts,
                    'backgroundColor' => array_slice($colors, 0, count($memberCounts)),
                    'borderColor' => '#FFFFFF', 
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'right', 
                ],
            ],
        ];
    }
}
