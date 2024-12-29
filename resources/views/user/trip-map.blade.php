<x-app-layout>
    <head>
        {{-- Required CSS --}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" />
        
        <style>
            .custom-popup .leaflet-popup-content-wrapper {
                background: rgba(255, 255, 255, 0.95);
                border-radius: 12px;
                box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            }

            .custom-popup .leaflet-popup-content {
                margin: 0;
                width: 300px !important;
                padding: 0;
            }

            .custom-popup .leaflet-popup-tip {
                background: rgba(255, 255, 255, 0.95);
            }

            .popup-content {
                width: 100%;
            }

            .popup-image {
                width: 100%;
                height: 150px;
                object-fit: cover;
                border-top-left-radius: 12px;
                border-top-right-radius: 12px;
            }

            .popup-details {
                padding: 16px;
            }

            .popup-button {
                display: inline-block;
                background-color: #4F46E5;
                color: white;
                padding: 8px 16px;
                border-radius: 6px;
                text-decoration: none;
                transition: background-color 0.3s ease;
                cursor: pointer;
                font-size: 14px;
            }

            .popup-button:hover {
                background-color: #4338CA;
            }

            .marker-hover {
                transition: all 0.3s ease;
                transform: scale(1.2);
            }

            .gallery-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
                padding: 1rem;
            }

            .photo-container {
                opacity: 0;
                transform: translateY(10px);
                animation: fadeInUp 0.5s ease forwards;
            }

            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            #map {
                width: 100%;
                height: 600px;
                z-index: 1;
            }
        </style>
    </head>

    <main class="flex flex-col items-center mt-8 px-4 md:px-8">
        {{-- Header Section with Stats --}}
        <div class="w-full max-w-6xl mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-center mb-4">
                Your Travel Memories
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

        <div id="memoriesModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
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
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <!-- Title Overlay -->
                        <div class="absolute bottom-0 left-0 p-6 text-white">
                            <h2 id="modalTitle" class="text-3xl font-bold mb-2"></h2>
                            <p id="modalLocation" class="text-lg opacity-90 mb-1"></p>
                            <p id="modalDates" class="text-sm opacity-80"></p>
                        </div>
                    </div>
    
                    <!-- Content Area -->
                    <div class="p-6">
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-4">Your Memories</h3>
                            
                            <!-- Upload Area -->
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
                <div class="popup-content">
                    <img src="${destination.image}" alt="${destination.name}" class="popup-image">
                    <div class="popup-details">
                        <h4 class="text-lg font-semibold mb-2">${destination.name}</h4>
                        <p class="text-sm text-gray-600 mb-1">${destination.location}</p>
                        <p class="text-sm text-gray-600 mb-3">
                            ${formatDate(destination.start_date)} - ${formatDate(destination.end_date)}
                        </p>
                        <button onclick="viewMemoriesAndClosePopup(${destination.id})" class="popup-button">
                            See Your Memories
                        </button>
                    </div>
                </div>
            `;

            const popup = L.popup({
                className: 'custom-popup',
                closeButton: true,
                closeOnClick: false
            }).setContent(popupContent);

            // Modify hover behavior
            let isOverMarker = false;
            let isOverPopup = false;

            marker.on('mouseover', function() {
                isOverMarker = true;
                if (!currentPopup) {
                    marker.bindPopup(popup).openPopup();
                    currentPopup = popup;
                }
            });

            marker.on('mouseout', function(e) {
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

            // Load existing memories
            const memories = memoriesStorage.get(destinationId) || [];
            updateMemoriesGrid(memories);

            // Show modal and prevent body scroll
            document.getElementById('memoriesModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function updateMemoriesGrid(memories) {
            const contentArea = document.querySelector('.p-6');
            contentArea.innerHTML = `
                <div class="mb-8">
                    <h3 class="text-xl font-semibold mb-4">Your Memories</h3>
                    
                    ${memories.length === 0 ? `
                        <!-- Large upload area when no photos -->
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
                    ` : ''}
                </div>

                <!-- Memories Grid -->
                <div id="memoriesGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
                    <!-- Memory items will be dynamically added here -->
                </div>

                ${memories.length > 0 ? `
                    <!-- Compact upload button when photos exist -->
                    <div class="flex justify-center">
                        <label class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer group">
                            <input type="file" multiple accept="image/*" onchange="handleFileUpload(event)" class="hidden">
                            <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add More Photos
                        </label>
                    </div>
                ` : ''}
            `;

            const memoriesGrid = document.getElementById('memoriesGrid');
            memories.forEach(memory => addMemoryToGrid(memory));
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

            // Add uploading class to memories grid
            const memoriesGrid = document.getElementById('memoriesGrid');
            memoriesGrid.classList.add('uploading');

            let completedUploads = 0;
            const validFiles = files.filter(file => {
                if (!file.type.startsWith('image/')) {
                    alert(`File ${file.name} is not an image.`);
                    return false;
                }
                if (file.size > 5 * 1024 * 1024) {
                    alert(`File ${file.name} is too large. Maximum size is 5MB.`);
                    return false;
                }
                return true;
            });

            validFiles.forEach((file, index) => {
                const reader = new FileReader();
                
                reader.onprogress = function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = (completedUploads + e.loaded / e.total) / validFiles.length * 100;
                        loadingOverlay.querySelector('.upload-progress-bar').style.width = `${percentComplete}%`;
                    }
                };

                reader.onload = function(e) {
                    completedUploads++;
                    const progress = (completedUploads / validFiles.length) * 100;
                    loadingOverlay.querySelector('.upload-progress-bar').style.width = `${progress}%`;
                    
                    // Add the memory to grid
                    addMemoryToGrid(e.target.result);

                    // Remove loading overlay and uploading class when all files are processed
                    if (completedUploads === validFiles.length) {
                        setTimeout(() => {
                            document.body.removeChild(loadingOverlay);
                            memoriesGrid.classList.remove('uploading');
                        }, 500);
                    }
                };

                reader.readAsDataURL(file);
            });
        }

        function addMemoryToGrid(imageUrl) {
            const memoriesGrid = document.getElementById('memoriesGrid');
            const memoryItem = document.createElement('div');
            memoryItem.className = 'relative aspect-square rounded-lg overflow-hidden group cursor-pointer photo-container';
            memoryItem.innerHTML = `
                <img src="${imageUrl}" alt="Memory" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="absolute bottom-2 right-2 flex gap-2">
                        <button onclick="deleteMemory(this)" class="p-1.5 rounded-full bg-white/80 hover:bg-white text-gray-700 hover:text-red-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            memoriesGrid.insertBefore(memoryItem, memoriesGrid.firstChild);

            // Update the view to show compact upload button
            const memories = Array.from(memoriesGrid.children);
            if (memories.length === 1) {
                updateMemoriesGrid(memories.map(memory => memory.querySelector('img').src));
            }
        }

        function deleteMemory(buttonElement) {
            const memoryItem = buttonElement.closest('.relative');
            memoryItem.remove();
        }

        function updateMemoriesGrid(memories) {
            const memoriesGrid = document.getElementById('memoriesGrid');
            memoriesGrid.innerHTML = '';
            memories.forEach(memory => addMemoryToGrid(memory));
        }

        // Close modal when clicking outside
        document.getElementById('memoriesModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });
    </script>
</x-app-layout>