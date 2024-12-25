<x-app-layout>
    <head>
        {{-- Link Leaflet's CSS --}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <!-- Link Swiper's CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>

        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <main class="items-center">
        <div class="relative h-screen">
            <img alt="Destinasi" class="w-full h-full object-cover rounded-b-lg" height="1080" src="images/Opening.png" width="1920"/>
            <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center">
                <h1 class="text-white text-5xl md:text-6xl font-bold"> Select Your Destination</h1>
                <p class="text-white text-lg md:text-xl mt-2">Lets Find Something Good For Your Destination</p>
            </div>
        </div>
        <div class="flex justify-center items-center min-h-screen">
            <div class="container w-3/4 mx-auto px-4">
                <div class="grid grid-cols-3 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- card --}}
                    @foreach ($dashboard as $destination)
                    <a href="/destination/{{ $destination['name_destination'] }}" class="{{ request()->routeIs('destination') ? 'active' : '' }}">
                        <div class="bg-white border border-gray-300 rounded-3xl shadow-lg overflow-hidden">
                            <img alt="Traditional Toraja houses with blue sky" class="w-fulll h-48 object-cover" height="400" src="https://storage.googleapis.com/a1aa/image/8VkhsEamSA4lB1e0zlWy9eGsJfqPmAuMMPdLXU6Xh6FSTRwnA.jpg" width="600"/>
                            <div class="p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">{{ $destination->status_trip }}</span>
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">2 Day</span>
                                </div>
                                <h2 class="text-xl font-bold mb-2">{{ $destination->name_destination }}</h2>
                                <div class="flex items-center text-gray-600 mb-1">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    <span class="text-sm">{{ $destination->date }}</span>
                                </div>
                                <div class="flex items-center text-gray-600 mb-1">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span class="text-sm">{{ $destination->address }}</span>
                                </div>
                                <div class="text-base text-gray-600 mb-1">Estimation</div>
                                <div class="flex justify-between items-center mb-2">
                                    <div class="text-red-500 text-xl font-bold mb-1">Rp. 1.700.000,00</div>
                                    <div class="flex justify-end">
                                        <i class="fas fa-arrow-right text-red-500"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
