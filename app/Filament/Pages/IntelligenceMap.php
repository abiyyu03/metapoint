<?php

namespace App\Filament\Pages;

use App\Models\Target;
use App\Models\Agent;
use Filament\Pages\Page;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Casts\Json;

class IntelligenceMap extends Page
{

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Map;

    protected string $view = 'filament.pages.intelligence-map';

    protected static ?string $navigationLabel = 'Intelligence Map';

    protected static ?string $title = 'Intelligence Map';

    protected static ?int $navigationSort = 10;

    // Optional: Grouping di sidebar
    // protected static ?string $navigationGroup = 'Intelligence';

    // Public properties untuk toggle
    public $showTargets = true;
    public $showAgents = true;

    public function getMarkers(): array
    {
        $markers = [];

        // Add Target markers (RED)
        if ($this->showTargets) {
            $targets = Target::with('organization')->select('id', 'fullname', 'lat', 'lng')
                ->whereNotNull('lat')
                ->whereNotNull('lng')
                ->where('lat', '<>', 0)
                ->where('lng', '<>', 0)
                ->get();


            foreach ($targets as $target) {
                $lat = (float) $target->lat;
                $lng = (float) $target->lng;

                if ($lat != 0 && $lng != 0) {
                    $markers[] = [
                        'lat' => $lat,
                        'lng' => $lng,
                        'popup' => $this->buildTargetPopup($target),
                        'tooltip' => $target->fullname,
                        'icon' => [
                            'iconUrl' => 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                            'shadowUrl' => 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                            'iconSize' => [25, 41],
                            'iconAnchor' => [12, 41],
                            'popupAnchor' => [1, -34],
                            'shadowSize' => [41, 41],
                        ],
                    ];
                }
            }
        }

        // Add Agent markers (BLUE)
        if ($this->showAgents) {
            $agents = Agent::with('operationalUnit')->select('id', 'fullname', 'lat', 'lng',)
                ->whereNotNull('lat')
                ->whereNotNull('lng')
                ->where('lat', '<>', 0)
                ->where('lng', '<>', 0)
                ->get();

            foreach ($agents as $agent) {
                $lat = (float) $agent->lat;
                $lng = (float) $agent->lng;

                if ($lat != 0 && $lng != 0) {
                    $markers[] = [
                        'lat' => $lat,
                        'lng' => $lng,
                        'popup' => $this->buildAgentPopup($agent),
                        'tooltip' => $agent->fullname,
                        'icon' => [
                            'iconUrl' => 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                            'shadowUrl' => 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                            'iconSize' => [25, 41],
                            'iconAnchor' => [12, 41],
                            'popupAnchor' => [1, -34],
                            'shadowSize' => [41, 41],
                        ],
                    ];
                }
            }
        }

        // dd(Json::encode($markers));
        return $markers;
    }

    protected function buildTargetPopup($target): string
    {
        $oganization = $target->organization->name ?? "-";
        return "
            <div class='p-3 min-w-[250px]'>
                <div class='mb-2'>
                    <span class='text-xs font-semibold text-red-600 uppercase'>● TARGET</span>
                    <h3 class='font-bold text-base mt-1'>{$target->fullname}</h3>
                </div>
                
                <div class='space-y-1 text-sm border-t pt-2'>
                    <div>
                        <span class='text-gray-500 text-xs'>NIK:</span>
                        <p class='font-medium'>{$target->nik}</p>
                    </div>
                    
                    <div class='space-y-1 text-sm border-t pt-2'>
                        <div>
                            <span class='text-gray-500 text-xs'>Kelompok:</span>
                            <p class='text-xs text-gray-700'>{$oganization}</p>
                        </div>
                    </div>
                    
                    <div>
                        <span class='text-gray-500 text-xs'>Address:</span>
                        <p class='text-xs text-gray-700'>{$target->address}</p>
                    </div>
                </div>
                
                <div class='flex gap-2 mt-3 pt-2 border-t'>
                    <a href='/admin/targets/{$target->id}' 
                       class='flex-1 text-center px-3 py-1.5 text-xs font-medium bg-red-500 text-white rounded hover:bg-red-600'>
                        View Detail
                    </a>
                    <a href='https://www.google.com/maps/dir/?api=1&destination={$target->lat},{$target->lng}' 
                       target='_blank'
                       class='flex-1 text-center px-3 py-1.5 text-xs font-medium bg-green-500 text-white rounded hover:bg-green-600'>
                        Direction
                    </a>
                </div>
            </div>
        ";
    }

    protected function buildAgentPopup($agent): string
    {
        $opsUnit = $agent->operationalUnit->name ?? "-";

        return "
            <div class='p-3 min-w-[250px]'>
                <div class='mb-2'>
                    <span class='text-xs font-semibold text-blue-600 uppercase'>● AGENT</span>
                    <h3 class='font-bold text-base mt-1'>{$agent->fullname}</h3>
                </div>
                
                <div class='space-y-1 text-sm border-t pt-2'>
                    <div>
                        <span class='text-gray-500 text-xs'>Address:</span>
                        <p class='text-xs text-gray-700'>{$agent->address}</p>
                    </div>
                </div> 
                <div class='space-y-1 text-sm border-t pt-2'>
                    <div>
                        <span class='text-gray-500 text-xs'>Ops Unit:</span>
                        <p class='text-xs text-gray-700'>{$opsUnit}</p>
                    </div>
                </div>
                
                <div class='flex gap-2 mt-3 pt-2 border-t'>
                    <a href='/admin/agents/{$agent->id}'
                       class='flex-1 text-center px-3 py-1.5 text-xs font-medium bg-blue-500 text-white rounded hover:bg-blue-600'>
                        View Detail
                    </a>
                    <a href='https://www.google.com/maps/dir/?api=1&destination={$agent->lat},{$agent->lng}'
                       target='_blank'
                       class='flex-1 text-center px-3 py-1.5 text-xs font-medium bg-green-500 text-white rounded hover:bg-green-600'>
                        Direction
                    </a>
                </div>
            </div>
        ";
    }

    public function getMapConfig(): array
    {
        return [
            'center' => [-2.0, 118.0], // Titik tengah Indonesia secara umum
            'zoom' => 4, // zoom agar seluruh Indonesia terlihat
            'bounds' => [
                'northEast' => [6.0, 141.0],
                'southWest' => [-10.0, 95.0],
            ],
            'clusterOptions' => [
                'maxClusterRadius' => 60,
                'spiderfyOnMaxZoom' => true,
                'showCoverageOnHover' => true,
                'zoomToBoundsOnClick' => true,
            ],
        ];
    }

    // Stats untuk cards
    public function getTotalTargets(): int
    {
        return Target::whereNotNull('lat')
            ->whereNotNull('lng')
            ->where('lat', '<>', 0)
            ->where('lng', '<>', 0)
            ->count();
    }

    public function getTotalAgents(): int
    {
        return Agent::whereNotNull('lat')
            ->whereNotNull('lng')
            ->where('lat', '<>', 0)
            ->where('lng', '<>', 0)
            ->count();
    }
}
