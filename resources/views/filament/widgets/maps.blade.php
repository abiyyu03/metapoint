<x-filament-widgets::widget>
    <x-filament::section>
        <div style="height: 500px;" wire:ignore>
            {{-- Muat CSS dan JS langsung di sini biar pasti tampil --}}
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

            <div id="map" style="height: 100%; border-radius: 10px; z-index: 1;"></div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Inisialisasi peta
                    var map = L.map('map').setView([-2.5, 118], 5);

                    // Tambahkan tile dari OpenStreetMap
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 18,
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    // Icon Agen (biru)
                    var agentIcon = L.icon({
                        iconUrl: 'https://cdn-icons-png.flaticon.com/512/149/149071.png',
                        iconSize: [30, 30],
                    });

                    // Icon Target (merah)
                    var targetIcon = L.icon({
                        iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                        iconSize: [30, 30],
                    });

                    // Data statis untuk demo
                    var agents = [{
                            name: "Agen Jakarta",
                            lat: -6.2,
                            lng: 106.8
                        },
                        {
                            name: "Agen Medan",
                            lat: 3.6,
                            lng: 98.67
                        },
                        {
                            name: "Agen Surabaya",
                            lat: -7.25,
                            lng: 112.75
                        },
                    ];

                    var targets = [{
                            name: "Target Bandung",
                            lat: -6.9,
                            lng: 107.6
                        },
                        {
                            name: "Target Makassar",
                            lat: -5.14,
                            lng: 119.41
                        },
                        {
                            name: "Target Bali",
                            lat: -8.4,
                            lng: 115.2
                        },
                    ];

                    // Tambahkan marker agen
                    agents.forEach(a => {
                        L.marker([a.lat, a.lng], {
                                icon: agentIcon
                            }).addTo(map)
                            .bindPopup(`<b>${a.name}</b><br><i>Tipe: Agen</i>`);
                    });

                    // Tambahkan marker target
                    targets.forEach(t => {
                        L.marker([t.lat, t.lng], {
                                icon: targetIcon
                            }).addTo(map)
                            .bindPopup(`<b>${t.name}</b><br><i>Tipe: Target</i>`);
                    });
                });
            </script>
        </div>

    </x-filament::section>
</x-filament-widgets::widget>
