<div x-data="leafletMap(@js($markers ?? []), @js($config ?? []))" x-init="$nextTick(() => initMap())" wire:ignore class="relative">
    <div x-ref="map" class="w-full h-[600px] rounded-lg border" style="height:600px"></div>
</div>

@script
    <script>
        Alpine.data('leafletMap', (markers, config) => ({
            map: null,
            markerClusterGroup: null,
            initCalledAt: Date.now(),

            getClusterColor(count) {
                if (count > 100) return '#FF6B6B';
                if (count > 50) return '#FFD700';
                if (count > 20) return '#45B7D1';
                if (count > 10) return '#4ECDC4';
                return '#FFA07A';
            },

            createIconCreateFunction() {
                return (cluster) => {
                    const count = cluster.getChildCount();
                    let bg = '';

                    if (count > 100) bg = 'linear-gradient(135deg, #ff6b6b, #ff8e53)';
                    else if (count > 50) bg = 'linear-gradient(135deg, #ffd93d, #ffb347)';
                    else if (count > 20) bg = 'linear-gradient(135deg, #4dadf7, #2c82c9)';
                    else if (count > 10) bg = 'linear-gradient(135deg, #4ECDC4, #45B7D1)';
                    else bg = 'linear-gradient(135deg, #9be7a7, #57cc99)';

                    return L.divIcon({
                        html: `<div style="
                background:${bg};
                width:55px;
                height:55px;
                border-radius:50%;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:18px;
            ">${count}</div>`,
                        className: 'custom-cluster-icon',
                        iconSize: [55, 55],
                        iconAnchor: [27.5, 27.5],
                    });
                };
            },

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

                if (!this.$refs || !this.$refs.map) {
                    console.error('❌ Map element not found. Make sure x-ref="map" ada di DOM.');
                    return;
                }

                try {
                    await this.waitForLeaflet().catch(err => {
                        console.error('❌ Leaflet not ready:', err);
                        throw err;
                    });

                    const hasMarkerCluster = await this.waitForMarkerCluster();

                    const defaultConfig = {
                        center: [-2.0, 118.0],
                        zoom: 4,
                        maxZoom: 18,
                        bounds: {
                            northEast: [6.0, 141.0],
                            southWest: [-10.0, 95.0]
                        },
                        clusterOptions: {
                            maxClusterRadius: 60,
                            spiderfyOnMaxZoom: true,
                            showCoverageOnHover: true,
                            zoomToBoundsOnClick: true
                        }
                    };
                    const finalConfig = {
                        ...defaultConfig,
                        ...config
                    };

                    this.map = L.map(this.$refs.map).setView(finalConfig.center, finalConfig.zoom);
                    console.log('✅ Map initialized');

                    try {
                        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                            attribution: '&copy; CartoDB & OSM'
                        }).addTo(this.map);

                        console.log('✅ Tile layer added');
                    } catch (err) {
                        console.warn('⚠️ Tile layer failed to add:', err);
                    }

                    if (hasMarkerCluster) {
                        try {
                            this.markerClusterGroup = L.markerClusterGroup({
                                ...finalConfig.clusterOptions,
                                iconCreateFunction: this.createIconCreateFunction(),
                            });

                        } catch (err) {
                            console.error('❌ Error creating markerClusterGroup, fallback to layerGroup:',
                                err);
                            this.markerClusterGroup = L.layerGroup();
                        }
                    } else {
                        console.warn('⚠️ MarkerCluster plugin not found — using layerGroup fallback');
                        this.markerClusterGroup = L.layerGroup();
                    }

                    if (!this.markerClusterGroup) {
                        this.markerClusterGroup = L.layerGroup();
                        console.warn('⚠️ markerClusterGroup was falsy — created layerGroup fallback');
                    }

                    if (markers && markers.length > 0) {
                        console.log('📍 Adding', markers.length, 'markers...');
                        this.addMarkers(markers);
                        console.log('✅ addMarkers returned');

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

                    try {
                        this.map.addLayer(this.markerClusterGroup);
                        console.log('✅ Cluster/layer group added to map');
                    } catch (err) {
                        console.error('❌ Failed to add cluster group to map:', err);
                    }

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
