<?php

namespace App\Filament\Widgets;

use App\Models\Target;
use Filament\Widgets\Widget;

class MapClusteringTargetAgent extends Widget
{
    protected string $view = 'filament.widgets.map-clustering-target-agent';
    protected static ?string $heading = 'Sebaran Agen dan Target di Indonesia';
    protected int|string|array $columnSpan = 'full';
    public function getMarkers(): array
    {
        return Target::query()
            ->select('name', 'address', 'latitude as lat', 'longitude as lng')
            ->get()
            ->toArray();
    }
}
