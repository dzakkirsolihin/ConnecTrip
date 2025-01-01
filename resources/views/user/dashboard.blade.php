<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

    <main class="bg-orange-50">
        <div class="relative h-[85vh]">
            <img alt="Adventure Destination" class="w-full h-full object-cover" src="images/Opening.png"/>
            <div class="absolute inset-0 bg-gradient-to-b from-black/50 to-black/30 flex flex-col justify-center items-center">
                <h1 class="text-white text-5xl md:text-7xl font-bold tracking-tight">Explore Together</h1>
                <p class="text-white/90 text-lg md:text-2xl mt-4 font-light">Your perfect travel companion awaits</p>
                <div class="mt-8">
                    <a href="#destinations" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-full font-medium transition-all">
                        Find Trips
                    </a>
                </div>
            </div>
        </div>

        <div id="destinations" class="py-16 px-4 md:px-8">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 text-center mb-12">Featured Destinations</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($dashboard as $trip)
                    <a href="/destination/{{ $trip->trip_name }}" class="group">
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all overflow-hidden">
                            <div class="relative">
                                <img alt="{{ $trip->trip_name }}" 
                                    class="w-full h-56 object-cover" 
                                    src="{{ $trip->images->isNotEmpty() ? asset('storage/' . $trip->images->random()->photo_path) : asset('images/default-trip.jpg') }}"/>
                                <div class="absolute top-4 right-4">
                                    <span class="bg-orange-500 text-white text-sm font-medium px-3 py-1 rounded-full">
                                        @if($trip->days_remaining > 0)
                                            {{ $trip->days_remaining }} {{ Str::plural('Day', $trip->days_remaining) }} Left
                                        @else
                                            Trip Started
                                        @endif
                                    </span>
                                </div>
                            </div>                            
                            
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-orange-500 transition-colors">
                                    {{ $trip->trip_name }}
                                </h3>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-gray-600">
                                        <i class="far fa-calendar-alt w-5"></i>
                                        <span class="ml-2 text-sm">{{ $trip->formatted_start_date }} - {{ $trip->formatted_end_date }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-map-marker-alt w-5"></i>
                                        <span class="ml-2 text-sm">{{ $trip->city }}</span>
                                    </div>
                                </div>
                            
                                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                    <div>
                                        <p class="text-sm text-gray-500">Starting from</p>
                                        <p class="text-xl font-bold text-orange-500">Rp {{ number_format($trip->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-orange-50 p-2 rounded-full group-hover:bg-orange-100 transition-all">
                                        <i class="fas fa-arrow-right text-orange-500"></i>
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