<?php

namespace App\Filament\Widgets;

use App\Models\Target;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TargetBehaviorChart extends ChartWidget
{
    protected ?string $heading = 'Hasil Perilaku Target';
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $targetData = Target::query()
            ->select(
                'target_classification',
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as date"),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('target_classification', DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy('date')
            ->get();

        $classifications = ['pro', 'netral', 'kontra'];
        $allDates = $targetData->pluck('date')->unique()->sort()->values();

        $mappedData = $targetData->groupBy('date')->map(function ($items) {
            return $items->keyBy('target_classification')->map(fn($item) => $item['count']);
        });

        $datasets = [];

        $colors = [
            'pro' => ['label' => 'Pro', 'color' => '#10B981'],   // Emerald 500
            'netral' => ['label' => 'Netral', 'color' => '#FBBF24'], // Amber 400
            'kontra' => ['label' => 'Kontra', 'color' => '#F87171'], // Red 400
        ];

        foreach ($classifications as $classification) {
            $dataPoints = [];

            foreach ($allDates as $date) {
                $count = $mappedData[$date][$classification] ?? 0;
                $dataPoints[] = $count;
            }

            $datasets[] = [
                'label' => $colors[$classification]['label'],
                'data' => $dataPoints,
                'backgroundColor' => $colors[$classification]['color'],
                'borderColor' => '#FFFFFF',
                'borderWidth' => 1,
            ];
        }

        $monthLabels = $allDates->map(function ($date) {
            $timestamp = strtotime($date . '-01');
            return date('M Y', $timestamp);
        })->toArray();

        return [
            'datasets' => $datasets,
            'labels' => $monthLabels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'stacked' => false,
                    'ticks' => [
                        'maxRotation' => 0,
                        'minRotation' => 0,
                    ],
                ],
                'y' => [
                    'stacked' => false, 
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1, // Memastikan skala Y berupa bilangan bulat
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
