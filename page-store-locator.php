<?php
/**
 * Template Name: Store Locator
 */

get_header();
?>

<div class="store-locator-container">
    <div class="store-locator-header">
        <h1>STORE LOCATOR</h1>
        <p>Find Skyworld Cannabis products at authorized dispensaries near you</p>
    </div>

    <div class="store-locator-search">
        <div class="search-input-container">
            <input type="text" id="location-search" placeholder="Enter your location (city, state, or zip code)" />
            <button id="search-btn" class="search-button">
                <i class="fas fa-search"></i>
            </button>
            <button id="locate-btn" class="locate-button" title="Use my current location">
                <i class="fas fa-location-arrow"></i>
            </button>
        </div>
    </div>

    <div class="store-locator-content">
        <div class="store-results-panel">
            <div class="results-header">
                <div class="results-count">
                    <span id="shop-count">Loading...</span>
                </div>
                <div class="view-toggle">
                    <button id="list-view-btn" class="view-btn active">
                        <i class="fas fa-list"></i> List
                    </button>
                    <button id="map-view-btn" class="view-btn">
                        <i class="fas fa-map"></i> Map
                    </button>
                </div>
            </div>

            <div class="loading-spinner" id="loading-spinner">
                <div class="spinner"></div>
                <p>Searching for dispensaries...</p>
            </div>

            <div class="store-list" id="store-list">
                <!-- Store results will be populated here -->
            </div>
        </div>

        <div class="store-map-container">
            <div id="store-map" class="store-map">
                <!-- Map will be initialized here -->
            </div>
        </div>
    </div>
</div>

<!-- Store Detail Modal -->
<div id="store-modal" class="store-modal" style="display: none;">
    <div class="store-modal-content">
        <div class="store-modal-header">
            <h3 id="modal-store-name"></h3>
            <button class="store-modal-close">&times;</button>
        </div>
        <div class="store-modal-body">
            <div class="store-modal-info">
                <div class="store-address">
                    <i class="fas fa-map-marker-alt"></i>
                    <span id="modal-store-address"></span>
                </div>
                <div class="store-phone">
                    <i class="fas fa-phone"></i>
                    <a id="modal-store-phone" href=""></a>
                </div>
                <div class="store-hours">
                    <i class="fas fa-clock"></i>
                    <div id="modal-store-hours"></div>
                </div>
                <div class="store-website">
                    <i class="fas fa-globe"></i>
                    <a id="modal-store-website" href="" target="_blank">Visit Website</a>
                </div>
            </div>
            <div class="store-modal-actions">
                <button class="btn btn-primary" id="modal-directions-btn">
                    <i class="fas fa-directions"></i> Get Directions
                </button>
                <button class="btn btn-secondary" id="modal-call-btn">
                    <i class="fas fa-phone"></i> Call Store
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Store Locator JavaScript
(function() {
    'use strict';

    // Configuration
    const CONFIG = {
        defaultCenter: { lat: 42.3601, lng: -71.0589 }, // Boston, MA
        defaultZoom: 10,
        maxRadius: 50, // miles
        apiEndpoint: '/wp-json/skyworld/v1/dispensaries'
    };

    // Sample dispensary data (replace with actual API integration)
    const SAMPLE_DISPENSARIES = [
        {
            id: 1,
            name: "Green Theory",
            address: "396 Hancock St, Quincy, MA 02171",
            phone: "(617) 328-0420",
            lat: 42.2529, lng: -71.0023,
            hours: {
                monday: "10:00 AM - 9:00 PM",
                tuesday: "10:00 AM - 9:00 PM",
                wednesday: "10:00 AM - 9:00 PM",
                thursday: "10:00 AM - 9:00 PM",
                friday: "10:00 AM - 9:00 PM",
                saturday: "10:00 AM - 9:00 PM",
                sunday: "10:00 AM - 8:00 PM"
            },
            website: "https://greentheoryma.com"
        },
        {
            id: 2,
            name: "NETA Northampton",
            address: "118 Conz St, Northampton, MA 01060",
            phone: "(413) 387-5840",
            lat: 42.3250, lng: -72.6412,
            hours: {
                monday: "9:00 AM - 8:00 PM",
                tuesday: "9:00 AM - 8:00 PM",
                wednesday: "9:00 AM - 8:00 PM",
                thursday: "9:00 AM - 8:00 PM",
                friday: "9:00 AM - 8:00 PM",
                saturday: "9:00 AM - 8:00 PM",
                sunday: "10:00 AM - 6:00 PM"
            },
            website: "https://netacare.org"
        },
        {
            id: 3,
            name: "Theory Wellness",
            address: "194 Milford St, Upton, MA 01568",
            phone: "(508) 529-0420",
            lat: 42.1751, lng: -71.6037,
            hours: {
                monday: "9:00 AM - 9:00 PM",
                tuesday: "9:00 AM - 9:00 PM",
                wednesday: "9:00 AM - 9:00 PM",
                thursday: "9:00 AM - 9:00 PM",
                friday: "9:00 AM - 9:00 PM",
                saturday: "9:00 AM - 9:00 PM",
                sunday: "10:00 AM - 7:00 PM"
            },
            website: "https://theorywellness.org"
        }
    ];

    class StoreLocator {
        constructor() {
            this.map = null;
            this.markers = [];
            this.infoWindows = [];
            this.currentLocation = null;
            this.dispensaries = SAMPLE_DISPENSARIES;
            
            this.init();
        }

        init() {
            this.bindEvents();
            this.initMap();
            this.loadStores();
        }

        bindEvents() {
            // Search button
            document.getElementById('search-btn').addEventListener('click', () => this.searchLocation());
            
            // Location input - search on Enter
            document.getElementById('location-search').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') this.searchLocation();
            });
            
            // Current location button
            document.getElementById('locate-btn').addEventListener('click', () => this.getCurrentLocation());
            
            // View toggle buttons
            document.getElementById('list-view-btn').addEventListener('click', () => this.toggleView('list'));
            document.getElementById('map-view-btn').addEventListener('click', () => this.toggleView('map'));
            
            // Modal close
            document.querySelector('.store-modal-close').addEventListener('click', () => this.closeModal());
            
            // Click outside modal to close
            document.getElementById('store-modal').addEventListener('click', (e) => {
                if (e.target.id === 'store-modal') this.closeModal();
            });
        }

        initMap() {
            // Initialize Google Maps (you'll need to add Google Maps API key)
            if (typeof google !== 'undefined' && google.maps) {
                this.map = new google.maps.Map(document.getElementById('store-map'), {
                    zoom: CONFIG.defaultZoom,
                    center: CONFIG.defaultCenter,
                    styles: this.getMapStyles()
                });
            } else {
                // Fallback for demo - show placeholder
                document.getElementById('store-map').innerHTML = '<div class="map-placeholder"><p>Map will be displayed here<br><small>Google Maps API integration required</small></p></div>';
            }
        }

        loadStores(searchLocation = null) {
            this.showLoading();
            
            // Simulate API call delay
            setTimeout(() => {
                let stores = this.dispensaries;
                
                if (searchLocation) {
                    // In real implementation, filter by distance from searchLocation
                    stores = this.filterStoresByDistance(stores, searchLocation);
                }
                
                this.displayStores(stores);
                this.displayMarkersOnMap(stores);
                this.hideLoading();
                
                document.getElementById('shop-count').textContent = `Number Of Shops: ${stores.length}`;
            }, 1000);
        }

        filterStoresByDistance(stores, location) {
            // In real implementation, calculate distances and filter
            return stores;
        }

        displayStores(stores) {
            const storeList = document.getElementById('store-list');
            storeList.innerHTML = '';

            stores.forEach(store => {
                const storeElement = this.createStoreElement(store);
                storeList.appendChild(storeElement);
            });
        }

        createStoreElement(store) {
            const storeDiv = document.createElement('div');
            storeDiv.className = 'store-item';
            storeDiv.innerHTML = `
                <div class="store-info">
                    <h3>${store.name}</h3>
                    <p class="store-address">
                        <i class="fas fa-map-marker-alt"></i>
                        ${store.address}
                    </p>
                    <p class="store-phone">
                        <i class="fas fa-phone"></i>
                        <a href="tel:${store.phone}">${store.phone}</a>
                    </p>
                    <div class="store-actions">
                        <button class="btn btn-outline" onclick="storeLocator.showStoreDetails(${store.id})">
                            View Details
                        </button>
                        <button class="btn btn-primary" onclick="storeLocator.getDirections('${store.address}')">
                            <i class="fas fa-directions"></i> Directions
                        </button>
                    </div>
                </div>
            `;
            
            return storeDiv;
        }

        displayMarkersOnMap(stores) {
            if (!this.map) return;

            // Clear existing markers
            this.markers.forEach(marker => marker.setMap(null));
            this.markers = [];
            this.infoWindows.forEach(infoWindow => infoWindow.close());
            this.infoWindows = [];

            // Add new markers
            stores.forEach(store => {
                const marker = new google.maps.Marker({
                    position: { lat: store.lat, lng: store.lng },
                    map: this.map,
                    title: store.name
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: this.createInfoWindowContent(store)
                });

                marker.addListener('click', () => {
                    this.infoWindows.forEach(iw => iw.close());
                    infoWindow.open(this.map, marker);
                });

                this.markers.push(marker);
                this.infoWindows.push(infoWindow);
            });

            // Adjust map bounds to show all markers
            if (this.markers.length > 0) {
                const bounds = new google.maps.LatLngBounds();
                this.markers.forEach(marker => bounds.extend(marker.getPosition()));
                this.map.fitBounds(bounds);
            }
        }

        createInfoWindowContent(store) {
            return `
                <div class="info-window">
                    <h4>${store.name}</h4>
                    <p>${store.address}</p>
                    <p><a href="tel:${store.phone}">${store.phone}</a></p>
                    <div class="info-window-actions">
                        <button onclick="storeLocator.showStoreDetails(${store.id})">Details</button>
                        <button onclick="storeLocator.getDirections('${store.address}')">Directions</button>
                    </div>
                </div>
            `;
        }

        searchLocation() {
            const query = document.getElementById('location-search').value.trim();
            if (!query) return;

            // In real implementation, geocode the address and search nearby stores
            this.loadStores(query);
        }

        getCurrentLocation() {
            if ('geolocation' in navigator) {
                this.showLoading();
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        this.currentLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        
                        if (this.map) {
                            this.map.setCenter(this.currentLocation);
                            this.map.setZoom(12);
                        }
                        
                        this.loadStores(this.currentLocation);
                    },
                    (error) => {
                        console.error('Geolocation error:', error);
                        alert('Unable to get your location. Please enter your address manually.');
                        this.hideLoading();
                    }
                );
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }

        showStoreDetails(storeId) {
            const store = this.dispensaries.find(s => s.id === storeId);
            if (!store) return;

            document.getElementById('modal-store-name').textContent = store.name;
            document.getElementById('modal-store-address').textContent = store.address;
            document.getElementById('modal-store-phone').textContent = store.phone;
            document.getElementById('modal-store-phone').href = `tel:${store.phone}`;
            
            // Format hours
            const hoursHtml = Object.entries(store.hours).map(([day, hours]) => 
                `<div><strong>${day.charAt(0).toUpperCase() + day.slice(1)}:</strong> ${hours}</div>`
            ).join('');
            document.getElementById('modal-store-hours').innerHTML = hoursHtml;
            
            document.getElementById('modal-store-website').href = store.website;
            
            // Bind action buttons
            document.getElementById('modal-directions-btn').onclick = () => this.getDirections(store.address);
            document.getElementById('modal-call-btn').onclick = () => window.open(`tel:${store.phone}`);

            document.getElementById('store-modal').style.display = 'flex';
        }

        closeModal() {
            document.getElementById('store-modal').style.display = 'none';
        }

        getDirections(address) {
            const encodedAddress = encodeURIComponent(address);
            const url = `https://www.google.com/maps/dir/?api=1&destination=${encodedAddress}`;
            window.open(url, '_blank');
        }

        toggleView(view) {
            const listBtn = document.getElementById('list-view-btn');
            const mapBtn = document.getElementById('map-view-btn');
            const storeResults = document.querySelector('.store-results-panel');
            const storeMap = document.querySelector('.store-map-container');

            if (view === 'list') {
                listBtn.classList.add('active');
                mapBtn.classList.remove('active');
                storeResults.style.display = 'block';
                storeMap.style.display = 'none';
            } else {
                mapBtn.classList.add('active');
                listBtn.classList.remove('active');
                storeResults.style.display = 'none';
                storeMap.style.display = 'block';
            }
        }

        showLoading() {
            document.getElementById('loading-spinner').style.display = 'block';
            document.getElementById('store-list').style.display = 'none';
        }

        hideLoading() {
            document.getElementById('loading-spinner').style.display = 'none';
            document.getElementById('store-list').style.display = 'block';
        }

        getMapStyles() {
            return [
                {
                    "featureType": "all",
                    "elementType": "geometry",
                    "stylers": [{"color": "#f5f5f5"}]
                },
                {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [{"color": "#e9e9e9"}, {"visibility": "on"}]
                }
                // Add more custom map styles as needed
            ];
        }
    }

    // Initialize store locator when page loads
    let storeLocator;
    document.addEventListener('DOMContentLoaded', function() {
        storeLocator = new StoreLocator();
        window.storeLocator = storeLocator; // Make globally accessible
    });

})();
</script>

<?php get_footer(); ?>