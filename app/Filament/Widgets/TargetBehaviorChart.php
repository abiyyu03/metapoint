<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TargetBehaviorChart extends ChartWidget
{
    protected ?string $heading = 'Hasil Perilaku Target';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Pro',
                    'data' => [10, 15, 20, 25],
                    'backgroundColor' => '#92f080',
                ],
                [
                    'label' => 'Netral',
                    'data' => [5, 10, 8, 12],
                    'backgroundColor' => '#efffeb',
                ],
                [
                    'label' => 'Kontra',
                    'data' => [2, 4, 3, 6],
                    'backgroundColor' => '#f08080',
                ],
            ],
            'labels' => ['Januari', 'Februari', 'Maret', 'April'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
