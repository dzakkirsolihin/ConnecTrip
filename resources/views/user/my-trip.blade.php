<x-app-layout>
    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
        @vite('resources/css/app.css')
    </head>
    <body class="font-poppins bg-slate-50 min-h-screen">
        <!-- Hero Section -->
        <div class="relative h-[500px] overflow-hidden">
            <div class="absolute inset-0 bg-black bg-opacity-40 z-10"></div>
            {{-- {{ asset('images/hero-image.jpg') }} --}}
            <img src="https://static.thehoneycombers.com/wp-content/uploads/sites/4/2024/09/Best-things-to-do-in-Bali-Indonesia-tours-and-attractions-1.jpeg" 
                 alt="Beautiful landscape with a temple and mountains" 
                 class="w-full h-full object-cover object-center transform scale-105"/>
            <div class="absolute inset-0 z-20 flex flex-col items-center justify-center text-white">
                <h1 class="text-6xl font-bold mb-4 tracking-wider">My Trip Journey</h1>
                <p class="text-xl text-gray-200 max-w-2xl text-center px-4">Track and reminisce your adventures across Indonesia</p>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="sticky top-0 z-30 bg-white bg-opacity-80 backdrop-blur-md shadow-sm">
            <div class="max-w-5xl mx-auto">
                <div class="flex justify-center py-4 gap-8">
                    <button onclick="showCategory('completed', this)" 
                            class="group relative text-lg font-medium px-6 py-2 rounded-full transition-all duration-300 text-gray-700 hover:text-indigo-600 active-tab">
                        <span class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            Completed
                        </span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
                    </button>
                    <button onclick="showCategory('ongoing', this)" 
                            class="group relative text-lg font-medium px-6 py-2 rounded-full transition-all duration-300 text-gray-700 hover:text-indigo-600">
                        <span class="flex items-center">
                            <i class="fas fa-plane mr-2"></i>
                            Ongoing
                        </span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
                    </button>
                    <button onclick="showCategory('upcoming', this)" 
                            class="group relative text-lg font-medium px-6 py-2 rounded-full transition-all duration-300 text-gray-700 hover:text-indigo-600">
                        <span class="flex items-center">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Upcoming
                        </span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Trip Cards Container -->
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div id="card-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 place-items-center">
                <!-- Cards will be dynamically loaded here -->
            </div>
        </div>

        <script>
            // Get trips data from controller
            const trips = @json($tripsData);

            function showCategory(category, button) {
                const cardContainer = document.getElementById('card-container');
                
                // Adjust grid based on number of items
                const tripCount = trips[category].length;
                let gridClass = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 place-items-center';
                
                if (tripCount === 1) {
                    gridClass = 'flex justify-center';
                } else if (tripCount === 4) {
                    gridClass = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 place-items-center';
                } else if (tripCount === 0) {
                    cardContainer.className = gridClass;
                    cardContainer.innerHTML = `
                        <div class="col-span-full text-center py-8">
                            <i class="fas fa-map-signs text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500 text-lg">No ${category} trips found</p>
                        </div>
                    `;
                    return;
                }
                
                cardContainer.className = gridClass;
                cardContainer.innerHTML = '';

                // Update active tab state
                document.querySelectorAll('.active-tab').forEach(btn => {
                    btn.classList.remove('active-tab');
                    btn.classList.remove('text-indigo-600');
                });
                button.classList.add('active-tab');
                button.classList.add('text-indigo-600');

                // Generate cards with animation delay
                trips[category].forEach((trip, index) => {
                    const card = `
                        <div class="w-full max-w-sm bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl opacity-0 translate-y-4"
                             style="animation: fadeIn 0.6s ease-out ${index * 100}ms forwards;">
                            <div class="relative group">
                                <img src="${trip.image_url}" 
                                     alt="${trip.name}" 
                                     class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110"/>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-2xl font-semibold text-gray-800 mb-2">${trip.name}</h3>
                                <div class="flex items-center text-gray-600 mb-2">
                                    <i class="fas fa-map-marker-alt mr-2 text-indigo-600"></i>
                                    <span>${trip.location}</span>
                                </div>
                                <div class="flex items-center text-gray-600 mb-2">
                                    <i class="fas fa-calendar-day mr-2 text-indigo-600"></i>
                                    <span>${trip.start_date} - ${trip.end_date}</span>
                                </div>
                                <div class="flex items-center text-gray-600 mb-2">
                                    <i class="fas fa-tag mr-2 text-indigo-600"></i>
                                    <span>Rp ${trip.price}</span>
                                </div>
                                <div class="flex items-center text-gray-600 mb-2">
                                    <i class="fas fa-user mr-2 text-indigo-600"></i>
                                    <span>${trip.full_name}</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fab fa-instagram mr-2 text-indigo-600"></i>
                                    <span>${trip.social_media}</span>
                                </div>
                            </div>
                        </div>`;
                    cardContainer.innerHTML += card;
                });
            }

            // Add animation keyframes
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(1rem);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            `;
            document.head.appendChild(style);

            // Initialize with completed trips
            document.addEventListener('DOMContentLoaded', () => {
                showCategory('completed', document.querySelector('.active-tab'));
            });
        </script>
    </body>
</x-app-layout>