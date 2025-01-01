<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    
    <!-- Registration Modal -->
    <div id="registrationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white rounded-xl max-w-3xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-orange-100">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-orange-800">Trip Registration</h3>
                    <button onclick="closeModal()" class="text-orange-500 hover:text-orange-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                <form method="POST" action="{{ route('registration.store', $tripsubmissions->id) }}" class="space-y-6">
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-orange-800">Personal Information</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-orange-700">Full Name</label>
                                <input type="text" name="full_name" id="full_name" 
                                    class="mt-1 block w-full rounded-lg border-orange-200 bg-white shadow-sm 
                                    focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    required>
                            </div>

                            <div>
                                <label for="age" class="block text-sm font-medium text-orange-700">Age</label>
                                <input type="number" name="age" id="age" 
                                    class="mt-1 block w-full rounded-lg border-orange-200 bg-white shadow-sm 
                                    focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="whatsapp" class="block text-sm font-medium text-orange-700">WhatsApp Number</label>
                                <input type="tel" name="whatsapp" id="whatsapp" 
                                    class="mt-1 block w-full rounded-lg border-orange-200 bg-white shadow-sm 
                                    focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    required>
                            </div>

                            <div>
                                <label for="emergency_contact" class="block text-sm font-medium text-orange-700">Emergency Contact</label>
                                <input type="tel" name="emergency_contact" id="emergency_contact" 
                                    class="mt-1 block w-full rounded-lg border-orange-200 bg-white shadow-sm 
                                    focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label for="instagram" class="block text-sm font-medium text-orange-700">Instagram Account</label>
                            <input type="text" name="instagram" id="instagram" 
                                class="mt-1 block w-full rounded-lg border-orange-200 bg-white shadow-sm 
                                focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                required>
                        </div>
                    </div>

                    <!-- Terms and Submit -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="terms" id="terms" value="1" required
                                class="h-4 w-4 rounded border-orange-300 text-orange-500 focus:ring-orange-200">
                            <label for="terms" class="ml-2 block text-sm text-orange-700">
                                I have read and agree to the ConnecTrip terms and conditions
                            </label>
                        </div>

                        <button type="submit" 
                            class="w-full py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium 
                            text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 
                            focus:ring-offset-2 focus:ring-orange-500">
                            Complete Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="bg-orange-50/50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Image Gallery Section -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
                <div class="lg:col-span-8">
                    <div class="relative h-[500px] rounded-2xl overflow-hidden shadow-lg">
                        @if($tripsubmissions->images->isNotEmpty())
                            <img 
                                src="{{ asset('storage/' . $tripsubmissions->images->first()->photo_path) }}"
                                alt="{{ $tripsubmissions->trip_name }}"
                                class="w-full h-full object-cover"
                            />
                        @endif
                        <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/60 to-transparent p-6">
                            <h1 class="text-3xl font-bold text-white">{{ $tripsubmissions->trip_name }}</h1>
                            <p class="text-white/90 mt-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>{{ $tripsubmissions->city }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="lg:col-span-4 grid grid-cols-2 gap-4">
                    @foreach($tripsubmissions->images->skip(1)->take(4) as $image)
                        <div class="relative rounded-xl overflow-hidden shadow-md h-[120px]">
                            <img 
                                src="{{ asset('storage/' . $image->photo_path) }}"
                                alt="Gallery image"
                                class="w-full h-full object-cover hover:scale-110 transition-transform duration-300"
                            />
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Trip Details and Booking Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Trip Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- About Section -->
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Trip</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $tripsubmissions->description }}</p>
                        
                        <!-- Trip Highlights -->
                        <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="flex items-center space-x-3 text-gray-600">
                                <i class="fas fa-clock text-orange-500"></i>
                                <span>{{ $tripsubmissions->duration }} Days</span>
                            </div>
                            <!-- Display Registration Slots -->
                            <div class="flex items-center space-x-3 text-gray-600">
                                <i class="fas fa-users text-orange-500"></i>
                                <span>
                                    {{ $tripsubmissions->registrations->count() }}/{{ $tripsubmissions->capacity }} Slots
                                </span>
                            </div>
                            <div class="flex items-center space-x-3 text-gray-600">
                                <i class="fas fa-calendar-alt text-orange-500"></i>
                                <span>{{ Carbon\Carbon::parse($tripsubmissions->start_date)->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center space-x-3 text-gray-600">
                                <i class="fas fa-map-marker-alt text-orange-500"></i>
                                <span>{{ $tripsubmissions->city }}</span>
                            </div>
                        </div>

                        @if($tripsubmissions->notes)
                            <div class="mt-6 p-4 bg-orange-50 rounded-lg border border-orange-100">
                                <h3 class="font-semibold text-orange-800 mb-2">Additional Notes</h3>
                                <p class="text-gray-600">{{ $tripsubmissions->notes }}</p>
                            </div>
                        @endif
                        @if($tripsubmissions->registrations->contains('user_id', auth()->id()))
                            <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200">
                                <h3 class="font-semibold text-green-800 mb-2">Grup WhatsApp</h3>
                                <p class="text-gray-600">
                                    Anda telah berhasil mendaftar ke trip ini. Silakan bergabung dengan grup WhatsApp untuk mendapatkan informasi lebih lanjut dan berkomunikasi dengan peserta lain.
                                </p>
                                <a href="{{ $tripsubmissions->whatsapp_group }}" target="_blank"
                                    class="inline-block mt-4 px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-500 transition">
                                    Join WhatsApp Group
                                </a>
                            </div>
                        @elseif($tripsubmissions->registrations->count() >= $tripsubmissions->capacity)
                            <div class="mt-6 p-4 bg-red-50 rounded-lg border border-red-200">
                                <h3 class="font-semibold text-red-800 mb-2">Pendaftaran Ditutup</h3>
                                <p class="text-gray-600">
                                    Maaf, kapasitas untuk trip ini sudah penuh. Anda tidak dapat mendaftar lagi untuk trip ini.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Booking Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-md p-6 sticky top-8">
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-600">Price per person</span>
                                <span class="text-2xl font-bold text-orange-500">
                                    Rp {{ number_format($tripsubmissions->price, 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center justify-between text-gray-600">
                                    <span>Available slots</span>
                                    <span>{{ $tripsubmissions->capacity }} slots</span>
                                </div>
                                <div class="flex items-center justify-between text-gray-600">
                                    <span>Trip duration</span>
                                    <span>{{ $tripsubmissions->duration }} Days</span>
                                </div>
                                <div class="flex items-center justify-between text-gray-600">
                                    <span>Trip date</span>
                                    <span>{{ Carbon\Carbon::parse($tripsubmissions->start_date)->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Registration Button -->
                        @if($tripsubmissions->registrations->contains('user_id', auth()->id()))
                            <button disabled
                                class="w-full bg-gray-400 text-white py-3 px-4 rounded-lg font-semibold cursor-not-allowed">
                                Already Registered
                            </button>
                        @elseif($tripsubmissions->registrations->count() >= $tripsubmissions->capacity)
                            <button disabled
                                class="w-full bg-gray-400 text-white py-3 px-4 rounded-lg font-semibold cursor-not-allowed">
                                Slots Full
                            </button>
                        @else
                            <button onclick="openModal()" 
                                class="w-full bg-orange-500 text-white py-3 px-4 rounded-lg font-semibold
                                hover:bg-orange-600 transition-colors duration-200 shadow-md
                                hover:shadow-lg transform hover:-translate-y-0.5">
                                Join Trip Now
                            </button>
                        @endif
                        
                        <p class="text-center text-sm text-gray-500 mt-4">
                            <i class="fas fa-lock mr-1"></i>
                            Secure booking process
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function openModal() {
            const modal = document.getElementById('registrationModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal() {
            const modal = document.getElementById('registrationModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    </script>
</x-app-layout>