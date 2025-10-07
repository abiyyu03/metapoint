<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TopOrganizationsChart extends ChartWidget
{
    protected ?string $heading = 'Jumlah Anggota Organisasi/Kelompok Terbanyak';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Anggota',
                    'data' => [35, 10, 30, 15, 25],
                    'borderColor' => '#93C5FD', 
                    'backgroundColor' => '#93C5FD33', 
                    'fill' => true,
                    'tension' => 0.4, 
                ],
            ],
            'labels' => ['OPM', 'LSM', 'BEM', 'PP', 'GMNI'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
