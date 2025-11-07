<x-filament-panels::page>

    {{-- Map Section --}}
    <x-filament::section>
        {{-- Header --}}
        <x-slot name="headerEnd">
            {{-- Toggle Controls --}}
            <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" wire:model.live="showTargets"
                        class="w-4 h-4 rounded border-gray-300 text-red-600 focus:ring-red-500" />
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">🔴 Targets</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" wire:model.live="showAgents"
                        class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">🔵 Agents</span>
                </label>
            </div>
        </x-slot>

        {{-- Loading State --}}
        <div wire:loading.delay
            class="mb-3 p-2 bg-blue-50 dark:bg-blue-900/20 rounded border border-blue-200 dark:border-blue-800">
            <div class="flex items-center gap-2 text-sm text-blue-700 dark:text-blue-300">
                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042
                        1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span>Updating map...</span>
            </div>
        </div>

        {{-- Map Container --}}
        @if (count($this->getMarkers()) > 0)
            <div class="relative h-[700px] rounded-lg overflow-hidden">

                {{-- Map --}}
                <x-leaflet-map :markers="$this->getMarkers()" :config="$this->getMapConfig()"
                    class="h-full w-full rounded-lg border border-gray-300 dark:border-gray-600 z-0"
                    style="margin-top:20px" />

                {{-- ✅ Legend (Centered + More Informative) --}}
                <div class="flex justify-center items-center gap-8 mb-4"
                    style="padding:8px 14px; background:rgba(255,255,255,0.92); border:1px solid #d1d5db; border-radius:8px;">

                    <div class="flex items-center gap-2">
                        <span
                            style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#e63946;"></span>
                        <span class="text-gray-800 dark:text-gray-200" style="font-weight:600;">Target</span>
                        <span class="text-gray-500 dark:text-gray-400 text-sm">(Lokasi calon sasaran)</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span
                            style="display:inline-block; width:14px; height:14px; border-radius:50%; background:#1d4ed8;"></span>
                        <span class="text-gray-800 dark:text-gray-200" style="font-weight:600;">Agent</span>
                        <span class="text-gray-500 dark:text-gray-400 text-sm">(Petugas lapangan)</span>
                    </div>

                </div>

            </div>
        @else
            {{-- Empty State --}}
            <div
                class="h-[700px] flex items-center justify-center bg-gray-50 dark:bg-gray-900 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                <div class="text-center p-8">
                    <div class="text-6xl mb-4">🗺️</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">No Data to Display</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        @if (!$showTargets && !$showAgents)
                            Please enable Targets or Agents using the toggles above
                        @else
                            No location data available in the database.<br>
                            Make sure lat/lng fields are filled for Targets and Agents.
                        @endif
                    </p>
                </div>
            </div>
        @endif

    </x-filament::section>
</x-filament-panels::page>
