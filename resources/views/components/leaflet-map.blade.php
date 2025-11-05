<div x-data="leafletMap(@js($markers ?? []), @js($config ?? []))" x-init="$nextTick(() => initMap())" wire:ignore class="relative">
    <div x-ref="map" class="w-full h-[600px] rounded-lg border" style="height:800px"></div>
</div>


@script
    <script>
        Alpine.data('leafletMap', (markers, config) => ({
            map: null,
            markerClusterGroup: null,
            initCalledAt: Date.now(),

            async waitForLeaflet(timeout = 6000) {
                const start = Date.now();
                return new Promise((resolve, reject) => {
                    const check = () => {
                        if (typeof L !== 'undefined') {
                            return resolve(true);
                        }
                        if (Date.now() - start > timeout) {
                            return reject(new Error('Leaflet did not load in time'));
                        }
                        setTimeout(check, 100);
                    };
                    check();
                });
            },

            async waitForMarkerCluster(timeout = 6000) {
                const start = Date.now();
                return new Promise((resolve) => {
                    const check = () => {
                        if (typeof L !== 'undefined' && typeof L.markerClusterGroup ===
                            'function') {
                            return resolve(true);
                        }
                        if (Date.now() - start > timeout) {
                            // don't reject — just resolve false to allow fallback
                            return resolve(false);
                        }
                        setTimeout(check, 100);
                    };
                    check();
                });
            },

            async initMap() {
                console.log('🚀 initMap() called', {
                    calledAt: this.initCalledAt
                });

                // Basic checks
                if (!this.$refs || !this.$refs.map) {
                    console.error('❌ Map element not found. Make sure x-ref="map" ada di DOM.');
                    return;
                }


                try {
                    // Wait for Leaflet
                    await this.waitForLeaflet().catch(err => {
                        console.error('❌ Leaflet not ready:', err);
                        throw err;
                    });

                    // Check markerCluster availability (but allow fallback)
                    const hasMarkerCluster = await this.waitForMarkerCluster();

                    // Default config
                    const defaultConfig = {
                        center: [0, 0],
                        zoom: 2,
                        maxZoom: 18,
                        clusterOptions: {
                            maxClusterRadius: 80,
                            spiderfyOnMaxZoom: true,
                            showCoverageOnHover: false,
                            zoomToBoundsOnClick: true
                        }
                    };
                    const finalConfig = {
                        ...defaultConfig,
                        ...config
                    };

                    // Initialize map
                    this.map = L.map(this.$refs.map).setView(finalConfig.center, finalConfig.zoom);
                    console.log('✅ Map initialized');

                    // Add tile layer (wrap in try)
                    try {
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors',
                            maxZoom: finalConfig.maxZoom
                        }).addTo(this.map);
                        console.log('✅ Tile layer added');
                    } catch (err) {
                        console.warn('⚠️ Tile layer failed to add:', err);
                    }

                    // Create cluster group or fallback
                    if (hasMarkerCluster) {
                        try {
                            this.markerClusterGroup = L.markerClusterGroup(finalConfig.clusterOptions);
                        } catch (err) {
                            console.error('❌ Error creating markerClusterGroup, fallback to layerGroup:',
                                err);
                            this.markerClusterGroup = L.layerGroup();
                        }
                    } else {
                        console.warn('⚠️ MarkerCluster plugin not found — using layerGroup fallback');
                        this.markerClusterGroup = L.layerGroup();
                    }

                    // Safety: ensure markerClusterGroup exists
                    if (!this.markerClusterGroup) {
                        this.markerClusterGroup = L.layerGroup();
                        console.warn('⚠️ markerClusterGroup was falsy — created layerGroup fallback');
                    }

                    // Add markers if any
                    console.log(this.$refs.map.offsetHeight, this.$refs.map.offsetWidth)
                    console.log('📊 Markers before adding:', markers);
                    if (markers && markers.length > 0) {
                        console.log('📍 Adding', markers.length, 'markers...');
                        this.addMarkers(markers);
                        console.log('✅ addMarkers returned');

                        // Fit bounds safely
                        try {
                            const bounds = this.markerClusterGroup.getBounds ? this.markerClusterGroup
                                .getBounds() : null;
                            if (bounds && typeof bounds.isValid === 'function' && bounds.isValid()) {
                                this.map.fitBounds(bounds, {
                                    padding: [50, 50]
                                });
                            } else {
                                console.warn('⚠️ Bounds invalid or not available');
                            }
                        } catch (err) {
                            console.warn('⚠️ Error fitting bounds:', err);
                        }
                    } else {
                        console.warn('⚠️ No markers to display (markers falsy or empty)');
                    }

                    // Add cluster/layer to map
                    try {
                        this.map.addLayer(this.markerClusterGroup);
                        console.log('✅ Cluster/layer group added to map');
                    } catch (err) {
                        console.error('❌ Failed to add cluster group to map:', err);
                    }

                    // Fix size
                    setTimeout(() => {
                        try {
                            this.map.invalidateSize();
                            console.log('✅ Map size invalidated');
                        } catch (err) {
                            console.warn('⚠️ invalidateSize failed:', err);
                        }
                    }, 200);

                    console.log('🎉 Map initialization complete!');
                } catch (err) {
                    console.error('❌ Fatal error during initMap:', err);
                }
            },

            addMarkers(markers) {
                markers.forEach((markerData, index) => {
                    try {
                        if (!markerData || markerData.lat == null || markerData.lng == null) {
                            console.warn('⚠️ Skipping invalid marker at index', index, markerData);
                            return;
                        }

                        const marker = L.marker([markerData.lat, markerData.lng]);

                        if (markerData.popup) marker.bindPopup(markerData.popup);
                        if (markerData.tooltip) marker.bindTooltip(markerData.tooltip);
                        if (markerData.icon) {
                            try {
                                marker.setIcon(L.icon(markerData.icon));
                            } catch (err) {
                                console.warn('⚠️ Invalid icon for marker', index, err);
                            }
                        }

                        this.markerClusterGroup.addLayer(marker);
                    } catch (error) {
                        console.error('❌ Error adding marker', index, ':', error);
                    }
                });
            },

            addMarker(lat, lng, options = {}) {
                const marker = L.marker([lat, lng]);
                if (options.popup) marker.bindPopup(options.popup);
                if (options.tooltip) marker.bindTooltip(options.tooltip);
                if (options.icon) marker.setIcon(L.icon(options.icon));
                this.markerClusterGroup.addLayer(marker);
            },

            clearMarkers() {
                if (this.markerClusterGroup && this.markerClusterGroup.clearLayers) {
                    this.markerClusterGroup.clearLayers();
                }
            },

            refreshMarkers(newMarkers) {
                this.clearMarkers();
                this.addMarkers(newMarkers || []);
                const bounds = this.markerClusterGroup.getBounds ? this.markerClusterGroup.getBounds() : null;
                if (bounds && bounds.isValid && bounds.isValid()) {
                    this.map.fitBounds(bounds, {
                        padding: [50, 50]
                    });
                }
            }
        }));

        console.log('✅ Alpine.data "leafletMap" registered');
    </script>
@endscript
