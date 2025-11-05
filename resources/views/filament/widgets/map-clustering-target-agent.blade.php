<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Header --}}
        <x-slot name="heading">
            Intelligence Map: Targets & Agents
        </x-slot>

        <x-slot name="headerEnd">
            <x-filament::button wire:click="resetFilters" size="sm" color="gray" icon="heroicon-o-arrow-path">
                Reset Filters
            </x-filament::button>
        </x-slot>

        {{-- Stats Cards --}}
        <div class="mb-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-red-50 dark:bg-red-950/50 rounded-lg p-4 border border-red-200 dark:border-red-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-red-600 dark:text-red-400">Total Targets</p>
                        <p class="text-2xl font-bold text-red-900 dark:text-red-100">
                            {{ $this->getTotalTargets() }}
                        </p>
                    </div>
                    <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 dark:bg-blue-950/50 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Active Agents</p>
                        <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">
                            {{ $this->getTotalAgents() }}
                        </p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-orange-50 dark:bg-orange-950/50 rounded-lg p-4 border border-orange-200 dark:border-orange-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-orange-600 dark:text-orange-400">High Priority</p>
                        <p class="text-2xl font-bold text-orange-900 dark:text-orange-100">
                            {{ $this->getHighPriorityTargets() }}
                        </p>
                    </div>
                    <div class="p-3 bg-orange-100 dark:bg-orange-900 rounded-full">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="mb-4 space-y-4">
            {{-- Toggle Switches --}}
            <div class="flex flex-wrap gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" wire:model.live="showTargets"
                        class="rounded border-gray-300 text-red-600 focus:ring-red-500" />
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Show Targets
                    </span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" wire:model.live="showAgents"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Show Agents
                    </span>
                </label>
            </div>

            {{-- Search and Filters --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5 text-gray-700 dark:text-gray-300">
                        Search
                    </label>
                    <input type="text" wire:model.live.debounce.500ms="searchTerm"
                        placeholder="Name, NIK, Address..."
                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm" />
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5 text-gray-700 dark:text-gray-300">
                        Gender
                    </label>
                    <select wire:model.live="filterGender"
                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                        <option value="all">All Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5 text-gray-700 dark:text-gray-300">
                        Organization
                    </label>
                    <select wire:model.live="filterOrganization"
                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                        @foreach ($this->getOrganizationOptions() as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5 text-gray-700 dark:text-gray-300">
                        Classification
                    </label>
                    <select wire:model.live="filterClassification"
                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                        @foreach ($this->getClassificationOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Loading State --}}
        <div wire:loading.delay class="mb-2">
            <div class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400">
                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span>Updating intelligence map...</span>
            </div>
        </div>

        {{-- Map --}}
        <div class="relative">
            @if (count($this->getMarkers()) > 0)
                <x-leaflet-map :markers="$this->getMarkers()" :config="$this->getMapConfig()"
                    class="h-[600px] rounded-lg border-2 border-gray-200 dark:border-gray-700 shadow-lg"
                    wire:key="map-{{ $showTargets }}-{{ $showAgents }}-{{ $filterGender }}-{{ $filterOrganization }}-{{ $filterClassification }}-{{ $searchTerm }}" />
            @else
                <div
                    class="h-[600px] flex items-center justify-center bg-gray-50 dark:bg-gray-800 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                    <div class="text-center p-6">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                            </path>
                        </svg>
                        <p class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-1">No locations to display</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            @if (!$showTargets && !$showAgents)
                                Please enable Targets or Agents to view the map
                            @else
                                Try adjusting your filters or search criteria
                            @endif
                        </p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Legend --}}
        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Map Legend</p>
                <span class="text-xs text-gray-500">Click markers for details</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                {{-- Targets --}}
                <div class="space-y-2">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase">Targets</p>
                    <div class="flex items-center gap-2 text-xs">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <span class="text-gray-700 dark:text-gray-300">High Priority</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs">
                        <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                        <span class="text-gray-700 dark:text-gray-300">Medium Priority</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs">
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                        <span class="text-gray-700 dark:text-gray-300">Low Priority</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs">
                        <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                        <span class="text-gray-700 dark:text-gray-300">Unclassified</span>
                    </div>
                </div>

                {{-- Agents --}}
                <div class="space-y-2">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase">Agents</p>
                    <div class="flex items-center gap-2 text-xs">
                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                        <span class="text-gray-700 dark:text-gray-300">Active Agents</span>
                    </div>
                </div>

                {{-- Info --}}
                <div class="space-y-2">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase">Info</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                        🔍 Markers cluster when zoomed out<br>
                        📍 Click clusters to expand<br>
                        🗺️ Click popup for details
                    </p>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
