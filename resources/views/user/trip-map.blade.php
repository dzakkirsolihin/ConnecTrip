<x-app-layout>
    <head>
        {{-- Required CSS --}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" />
        
        {{-- Only keeping essential custom styles that can't be handled by Tailwind --}}
        <style>
            .custom-popup .leaflet-popup-content-wrapper {
                @apply bg-white/95 rounded-xl shadow-lg;
            }

            .custom-popup .leaflet-popup-content {
                margin: 0;
                width: 300px !important;
                padding: 0;
            }

            .custom-popup .leaflet-popup-tip {
                @apply bg-white/95;
            }

            #map {
                width: 100%;
                height: 600px;
                z-index: 1;
            }

            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .loading-spinner {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    </head>

    <main class="flex flex-col items-center mt-8 px-4 md:px-8">
        {{-- Header Section with Stats --}}
        <div class="w-full max-w-6xl mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-center mb-4">
                Your Trip Memories
            </h1>
            <div class="flex justify-center gap-8 text-center">
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-3xl font-bold text-indigo-600">5</p>
                    <p class="text-gray-600">Places Visited</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-3xl font-bold text-indigo-600">3</p>
                    <p class="text-gray-600">Total Trips</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-3xl font-bold text-indigo-600">20</p>
                    <p class="text-gray-600">Photos Captured</p>
                </div>
            </div>
        </div>
        
        {{-- Map and Timeline Section --}}
        <div class="w-full max-w-6xl flex flex-col md:flex-row gap-4 mb-8">
            {{-- Main Map --}}
            <div class="w-full md:w-3/4">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div id="map"></div>
                </div>
            </div>

            {{-- Travel Timeline --}}
            <div class="w-full md:w-1/4">
                <div class="bg-white rounded-lg shadow-lg p-4 h-[600px] overflow-y-auto">
                    <div class="mb-4">
                        <label for="timelineYearSelect" class="block text-gray-600 font-medium">Select Year:</label>
                        <select id="timelineYearSelect" class="w-full p-2 border rounded-lg" onchange="updateTimeline()">
                            <!-- Options will be dynamically added -->
                        </select>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Your Travel Timeline</h3>
                    <div id="timeline" class="space-y-4 border-l-2 border-indigo-500 pl-4">
                        <!-- Timeline items will be dynamically added -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Memories Modal -->
        <div id="memoriesModal" class="hidden fixed inset-0 bg-black/50 z-50 overflow-y-auto">
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative bg-white w-full max-w-4xl rounded-xl shadow-lg overflow-hidden">
                    <!-- Close Button -->
                    <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 z-10 p-1 rounded-full hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
    
                    <!-- Header Image -->
                    <div class="relative h-[300px] w-full">
                        <img id="modalHeaderImage" class="w-full h-full object-cover" src="" alt="">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-6 text-white">
                            <h2 id="modalTitle" class="text-3xl font-bold mb-2"></h2>
                            <p id="modalLocation" class="text-lg opacity-90 mb-1"></p>
                            <p id="modalDates" class="text-sm opacity-80"></p>
                        </div>
                    </div>
    
                    <!-- Content Area -->
                    <div class="p-6">
                        <!-- Memories Grid -->
                        <div id="memoriesGrid" class="space-y-6">
                            <!-- Upload Area -->
                            <div class="mb-8">
                                <h3 class="text-xl font-semibold mb-4">Your Memories</h3>
                                <label class="block w-full border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50 transition-all group">
                                    <input type="file" multiple accept="image/*" onchange="handleFileUpload(event)" class="hidden">
                                    <div class="space-y-2">
                                        <svg class="w-10 h-10 mx-auto text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <p class="text-gray-600 group-hover:text-gray-900">Click or drag photos to upload</p>
                                        <p class="text-sm text-gray-500">Support JPG, PNG (max. 5MB)</p>
                                    </div>
                                </label>
                            </div>
                        </div>
    
                        <!-- Memories Grid -->
                        <div id="memoriesGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            <!-- Memory items will be dynamically added here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Required Scripts --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const newStyles = `
            .loading-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            }

            .loading-spinner {
                width: 50px;
                height: 50px;
                border: 3px solid #f3f3f3;
                border-top: 3px solid #3498db;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            .upload-progress {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: #e2e8f0;
            }

            .upload-progress-bar {
                height: 100%;
                background: #4F46E5;
                transition: width 0.3s ease;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            .uploading {
                opacity: 0.7;
                pointer-events: none;
            }
        `;
        const destinations = [
            {
                id: 1,
                name: "Bali",
                year: 2023,
                start_date: "2023-01-10",
                end_date: "2023-01-15",
                latitude: -8.4095,
                longitude: 115.1889,
                image: "https://cdn-ilbjhnn.nitrocdn.com/UzaWnNlGMIDRjWEXrjLYmxYxPOtQLvHH/assets/images/optimized/rev-9cc84da/www.water-sport-bali.com/wp-content/uploads/2012/04/Tips-Wisata-Bali-2.jpg",
                location: "Denpasar, Bali"
            },
            {
                id: 2,
                name: "Borobudur",
                year: 2023,
                start_date: "2023-02-05",
                end_date: "2023-02-10",
                latitude: -7.6079,
                longitude: 110.2038,
                image: "https://i.ytimg.com/vi/dwIN_k4ZQSU/sddefault.jpg",
                location: "Magelang, Central Java"
            },
            {
                id: 3,
                name: "Raja Ampat",
                year: 2024,
                start_date: "2024-03-15",
                end_date: "2024-03-20",
                latitude: -0.5897,
                longitude: 130.1018,
                image: "https://www.indonesia.travel/content/dam/indtravelrevamp/en/destinations/destination-update-may-2019/RA_Pianemoisland_indtravel.jpg",
                location: "West Papua"
            },
            {
                id: 4,
                name: "Bromo",
                year: 2024,
                start_date: "2024-05-01",
                end_date: "2024-05-10",
                latitude: -7.9425,
                longitude: 112.9530,
                image: "https://nusantara-news.co/wp-content/uploads/2023/12/WhatsApp-Image-2023-06-28-at-18.29.33.jpeg",
                location: "East Java"
            },
            {
                id: 5,
                name: "Toba Lake",
                year: 2024,
                start_date: "2024-06-15",
                end_date: "2024-06-20",
                latitude: 2.6736,
                longitude: 98.8675,
                image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKPLd5O0Mb-30Dyogluvg9CPdy3pbuRVsC8A&s",
                location: "North Sumatra"
            }
        ];

        let map;
        let markers = new Map();
        let currentPopup = null;

        document.addEventListener('DOMContentLoaded', function () {
            initializeMap();
            populateTimelineYearDropdown();
            updateTimeline();
        });

        function initializeMap() {
            map = L.map('map').setView([-2.5489, 118.0149], 5); // Center on Indonesia

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);
        }

        const styleSheet = document.createElement("style");
        styleSheet.textContent = newStyles;
        document.head.appendChild(styleSheet);

        // Modify the marker creation function to improve popup behavior
        function createMarker(destination) {
            const marker = L.marker([destination.latitude, destination.longitude]);
            
            const popupContent = `
                <div class="popup-content w-[320px] bg-white rounded-xl overflow-hidden shadow-lg">
                    <!-- Image Container with Gradient Overlay -->
                    <div class="relative h-40 overflow-hidden">
                        <img src="${destination.image}" 
                            alt="${destination.name}" 
                            class="w-full h-full object-cover transition duration-300 hover:scale-105"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    </div>

                    <!-- Content Container -->
                    <div class="p-3 space-y-2">
                        <!-- Location Header -->
                        <div class="space-y-1">
                            <h4 class="text-lg font-semibold text-gray-800">${destination.name}</h4>
                            <div class="flex items-center gap-1 text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-sm">${destination.location}</p>
                            </div>
                        </div>

                        <!-- Date Info -->
                        <div class="flex items-center gap-1 text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm">${formatDate(destination.start_date)} - ${formatDate(destination.end_date)}</p>
                        </div>

                        <!-- Action Button -->
                        <button onclick="viewMemoriesAndClosePopup(${destination.id})" 
                                class="w-full mt-2 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 
                                    text-white rounded-lg transition duration-300 ease-in-out
                                    flex items-center justify-center gap-2 group">
                            <span>See Your Memories</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;

            const popup = L.popup({
                className: 'custom-popup',
                closeButton: true,
                closeOnClick: false,
                maxWidth: 320
            }).setContent(popupContent);

            // Hover behavior
            let isOverMarker = false;
            let isOverPopup = false;

            marker.on('mouseover', function() {
                isOverMarker = true;
                if (!currentPopup) {
                    marker.bindPopup(popup).openPopup();
                    currentPopup = popup;
                }
            });

            marker.on('mouseout', function() {
                isOverMarker = false;
                setTimeout(() => {
                    if (!isOverMarker && !isOverPopup) {
                        marker.closePopup();
                        currentPopup = null;
                    }
                }, 100);
            });

            popup.on('add', function() {
                const popupElement = document.querySelector('.leaflet-popup');
                if (popupElement) {
                    popupElement.addEventListener('mouseenter', function() {
                        isOverPopup = true;
                    });
                    
                    popupElement.addEventListener('mouseleave', function() {
                        isOverPopup = false;
                        setTimeout(() => {
                            if (!isOverMarker && !isOverPopup) {
                                marker.closePopup();
                                currentPopup = null;
                            }
                        }, 100);
                    });
                }
            });

            return marker;
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-GB', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        function populateTimelineYearDropdown() {
            const yearSelect = document.getElementById('timelineYearSelect');
            const years = [...new Set(destinations.map(dest => dest.year))].sort((a, b) => b - a);
            
            years.forEach(year => {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearSelect.appendChild(option);
            });

            // Set default to current year or latest year if current year not available
            const currentYear = new Date().getFullYear();
            const defaultYear = years.includes(currentYear) ? currentYear : Math.max(...years);
            yearSelect.value = defaultYear;
        }

        function updateMarkers(year) {
            // Clear existing markers
            markers.forEach(marker => map.removeLayer(marker));
            markers.clear();

            // Add new markers for the selected year
            const yearDestinations = destinations.filter(dest => dest.year === year);
            yearDestinations.forEach(destination => {
                const marker = createMarker(destination);
                marker.addTo(map);
                markers.set(destination.id, marker);
            });

            // Adjust map view to show all markers if there are any
            if (yearDestinations.length > 0) {
                const bounds = L.latLngBounds(yearDestinations.map(dest => [dest.latitude, dest.longitude]));
                map.fitBounds(bounds, { padding: [50, 50] });
            }
        }

        function updateTimeline() {
            const selectedYear = parseInt(document.getElementById('timelineYearSelect').value);
            const filteredDestinations = destinations.filter(dest => dest.year === selectedYear);
            const timeline = document.getElementById('timeline');

            timeline.innerHTML = ''; // Clear existing timeline items

            // Update markers for the selected year
            updateMarkers(selectedYear);

            filteredDestinations.forEach(destination => {
                const timelineItem = document.createElement('div');
                timelineItem.className = "mb-4 cursor-pointer hover:bg-gray-50 p-2 rounded transition";
                timelineItem.innerHTML = `
                    <p class="font-medium">${destination.name}</p>
                    <p class="text-sm text-gray-600">${new Date(destination.start_date).toLocaleDateString('en-GB', {
                        month: 'short',
                        year: 'numeric'
                    })}</p>
                `;

                timelineItem.addEventListener('click', () => {
                    // Focus on the destination's marker without creating a new one
                    const marker = markers.get(destination.id);
                    if (marker) {
                        map.setView([destination.latitude, destination.longitude], 12);
                        marker.openPopup();
                    }
                });

                timeline.appendChild(timelineItem);
            });
        }

        // Simulated memory storage (replace with actual backend storage)
        const memoriesStorage = new Map();

        function viewMemories(destinationId) {
            const destination = destinations.find(d => d.id === destinationId);
            if (!destination) return;

            // Update modal content
            document.getElementById('modalHeaderImage').src = destination.image;
            document.getElementById('modalTitle').textContent = destination.name;
            document.getElementById('modalLocation').textContent = destination.location;
            document.getElementById('modalDates').textContent = `${formatDate(destination.start_date)} - ${formatDate(destination.end_date)}`;

            // Fetch and load existing memories
            fetch(`/memories/${destinationId}`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(memories => {
                if (memories.error) {
                    throw new Error(memories.error);
                }
                updateMemoriesGrid(memories);
            })
            .catch(error => {
                console.error('Error fetching memories:', error);
                alert('Error loading memories: ' + error.message);
            });

            // Show modal
            document.getElementById('memoriesModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function updateMemoriesGrid(memories) {
            const memoriesGrid = document.getElementById('memoriesGrid');
            memoriesGrid.innerHTML = '';
            
            // Container untuk semua konten
            const contentContainer = document.createElement('div');
            contentContainer.className = 'space-y-6';
            
            // Grid untuk foto-foto
            const photosGrid = document.createElement('div');
            photosGrid.className = 'grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4';
            
            // Tambahkan foto-foto yang ada
            memories.forEach(memory => {
                const memoryItem = document.createElement('div');
                memoryItem.className = 'relative aspect-square rounded-lg overflow-hidden group cursor-pointer photo-container';
                memoryItem.innerHTML = `
                    <img src="${memory.url}" alt="Memory" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="absolute bottom-2 right-2 flex gap-2">
                            <button onclick="deleteMemory(this, ${memory.id})" class="p-1.5 rounded-full bg-white/80 hover:bg-white text-gray-700 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
                photosGrid.appendChild(memoryItem);
            });
            
            // Tambahkan grid foto ke container
            contentContainer.appendChild(photosGrid);
            
            // Tambahkan tombol upload di bawah grid
            const uploadButton = document.createElement('div');
            uploadButton.className = 'flex justify-center mt-6';
            uploadButton.innerHTML = `
                <label class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 cursor-pointer transition-colors duration-200 ease-in-out gap-2">
                    <input type="file" multiple accept="image/*" onchange="handleFileUpload(event)" class="hidden">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Photo Memories
                </label>
            `;
            contentContainer.appendChild(uploadButton);
            
            // Tambahkan semua konten ke memoryGrid
            memoriesGrid.appendChild(contentContainer);
        }

        function closeModal() {
            document.getElementById('memoriesModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // New function to handle viewing memories and closing popup
        function viewMemoriesAndClosePopup(destinationId) {
            if (currentPopup) {
                currentPopup.close();
                currentPopup = null;
            }
            viewMemories(destinationId);
        }

        // Modify file upload handling with loading animation
        function handleFileUpload(event) {
            const files = Array.from(event.target.files);
            if (files.length === 0) return;

            const destinationId = getCurrentDestinationId(); // Tambahkan fungsi untuk mendapatkan ID destinasi aktif
            const formData = new FormData();
            
            files.forEach(file => {
                if (!file.type.startsWith('image/')) {
                    alert(`File ${file.name} is not an image.`);
                    return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    alert(`File ${file.name} is too large. Maximum size is 5MB.`);
                    return;
                }
                formData.append('photos[]', file);
            });
            
            formData.append('destination_id', destinationId);

            // Create loading overlay
            const loadingOverlay = document.createElement('div');
            loadingOverlay.className = 'loading-overlay';
            loadingOverlay.innerHTML = `
                <div class="bg-white p-6 rounded-lg shadow-xl">
                    <div class="loading-spinner mb-4"></div>
                    <p class="text-center text-gray-700">Uploading photos...</p>
                    <div class="upload-progress mt-4">
                        <div class="upload-progress-bar" style="width: 0%"></div>
                    </div>
                </div>
            `;
            document.body.appendChild(loadingOverlay);

            // Add CSRF token to headers
            const headers = {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            };

            // Upload photos
            fetch('/memories/upload', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'  // Tambahkan ini
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }
                data.forEach(photo => addMemoryToGrid(photo.url, photo.id));
                document.body.removeChild(loadingOverlay);
            })
            .catch(error => {
                console.error('Error uploading photos:', error);
                alert('Error uploading photos: ' + error.message);
                document.body.removeChild(loadingOverlay);
            });
        }

        function addMemoryToGrid(imageUrl, photoId) {
            const photosGrid = document.querySelector('#memoriesGrid .grid');
            const memoryItem = document.createElement('div');
            memoryItem.className = 'relative aspect-square rounded-lg overflow-hidden group cursor-pointer photo-container';
            memoryItem.innerHTML = `
                <img src="${imageUrl}" alt="Memory" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="absolute bottom-2 right-2 flex gap-2">
                        <button onclick="deleteMemory(this, ${photoId})" class="p-1.5 rounded-full bg-white/80 hover:bg-white text-gray-700 hover:text-red-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            photosGrid.insertBefore(memoryItem, photosGrid.firstChild);
        }

        function updateUploadButtonVisibility() {
            const memoriesGrid = document.getElementById('memoriesGrid');
            const contentArea = document.querySelector('.p-6');
            const hasMemories = memoriesGrid.children.length > 0;

            // Update content area with appropriate upload interface
            if (hasMemories && !contentArea.querySelector('.inline-flex')) {
                // Add compact upload button if it doesn't exist
                const uploadButton = document.createElement('div');
                uploadButton.className = 'flex justify-center mt-6';
                uploadButton.innerHTML = `
                    <label class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer group">
                        <input type="file" multiple accept="image/*" onchange="handleFileUpload(event)" class="hidden">
                        <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add More Photos
                    </label>
                `;
                contentArea.appendChild(uploadButton);
            }
        }

        function deleteMemory(buttonElement, photoId) {
            if (confirm('Are you sure you want to delete this photo?')) {
                fetch(`/memories/${photoId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const memoryItem = buttonElement.closest('.relative');
                        memoryItem.remove();
                    }
                })
                .catch(error => {
                    console.error('Error deleting photo:', error);
                    alert('Error deleting photo. Please try again.');
                });
            }
        }

        // Close modal when clicking outside
        document.getElementById('memoriesModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });

        function getCurrentDestinationId() {
            const modalTitle = document.getElementById('modalTitle').textContent;
            const destination = destinations.find(d => d.name === modalTitle);
            return destination ? destination.id : null;
        }
    </script>
</x-app-layout>
