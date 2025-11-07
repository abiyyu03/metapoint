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

        return $markers;
    }

    protected function buildTargetPopup($target): string
    {
        $oganization = $target->organization->name ?? "-";

        return "
        <div style='padding:12px; min-width:240px; font-family:system-ui, sans-serif;'>
            
            <div style='margin-bottom:8px;'>
                <span style='font-size:11px; font-weight:600; color:#dc2626; text-transform:uppercase;'>● Target</span>
                <h3 style='font-size:16px; font-weight:700; margin-top:4px;'>{$target->fullname}</h3>
            </div>

            <div style='border-top:1px solid #e5e7eb; padding-top:8px; font-size:13px; color:#374151; line-height:1.3;'>

                <div style='margin-bottom:6px;'>
                    <span style='font-size:11px; color:#6b7280;'>NIK:</span><br>
                    <span style='font-weight:600;'>{$target->nik}</span>
                </div>

                <div style='margin-bottom:6px;'>
                    <span style='font-size:11px; color:#6b7280;'>Kelompok:</span><br>
                    <span>{$oganization}</span>
                </div>

                <div style='margin-bottom:6px;'>
                    <span style='font-size:11px; color:#6b7280;'>Alamat:</span><br>
                    <span>{$target->address}</span>
                </div>

            </div>

            <div style='display:flex; gap:8px; margin-top:10px; padding-top:8px; border-top:1px solid #e5e7eb;'>

                <a href='/admin/targets/{$target->id}'
                   style='flex:1; text-align:center; padding:6px 0; font-size:12px; font-weight:600; background:#dc2626; color:white; border-radius:6px; text-decoration:none;'>
                    Detail
                </a>

                <a href='https://www.google.com/maps/dir/?api=1&destination={$target->lat},{$target->lng}'
                   target='_blank'
                   style='flex:1; text-align:center; padding:6px 0; font-size:12px; font-weight:600; background:#16a34a; color:white; border-radius:6px; text-decoration:none;'>
                    Arahkan
                </a>

            </div>

        </div>
    ";
    }


    protected function buildAgentPopup($agent): string
    {
        $opsUnit = $agent->operationalUnit->name ?? "-";

        return "
        <div style='padding:12px; min-width:250px; font-family:inherit;'>
            <div style='margin-bottom:6px;'>
                <span style='font-size:10px; font-weight:600; color:#2563eb; text-transform:uppercase;'>● AGENT</span>
                <h3 style='font-weight:700; font-size:15px; margin-top:4px;'>{$agent->fullname}</h3>
            </div>

            <div style='padding-top:8px; border-top:1px solid #e5e7eb;'>
                <div style='margin-bottom:6px;'>
                    <span style='font-size:10px; color:#6b7280;'>Address:</span>
                    <p style='font-size:12px; color:#374151; margin:0;'>{$agent->address}</p>
                </div>

                <div style='margin-bottom:6px;'>
                    <span style='font-size:10px; color:#6b7280;'>Ops Unit:</span>
                    <p style='font-size:12px; color:#374151; margin:0;'>{$opsUnit}</p>
                </div>
            </div>

            <div style='display:flex; gap:6px; margin-top:10px; padding-top:8px; border-top:1px solid #e5e7eb;'>
                <a href='/admin/agents/{$agent->id}'
                    style='flex:1; text-align:center; padding:6px; font-size:11px; font-weight:500; background:#3b82f6; color:white; border-radius:4px; text-decoration:none;'>
                    View Detail
                </a>

                <a href='https://www.google.com/maps/dir/?api=1&destination={$agent->lat},{$agent->lng}'
                    target='_blank'
                    style='flex:1; text-align:center; padding:6px; font-size:11px; font-weight:500; background:#22c55e; color:white; border-radius:4px; text-decoration:none;'>
                    Direction
                </a>
            </div>
        </div>
    ";
    }


    public function getMapConfig(): array
    {
        return [
            'center' => [-2.0, 118.0],
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
