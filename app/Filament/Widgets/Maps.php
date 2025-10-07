<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class Maps extends Widget
{
    protected static ?string $heading = 'Sebaran Agen dan Target di Indonesia';
    protected string $view = 'filament.widgets.maps';
    public function getColumnSpan(): string
    {
        return 'full';
    }
}
