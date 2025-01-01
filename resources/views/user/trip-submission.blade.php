<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-orange-50/50 overflow-hidden shadow-lg sm:rounded-xl">
                <!-- Tab Navigation -->
                <div class="border-b border-orange-200">
                    <nav class="flex justify-center space-x-8 px-6" aria-label="Tabs">
                        <button
                            onclick="switchTab('submit')"
                            data-tab="submit"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 whitespace-nowrap group border-orange-500 text-orange-600"
                        >
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Submit New Trip
                            </span>
                        </button>
                        <button
                            onclick="switchTab('submissions')"
                            data-tab="submissions"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 whitespace-nowrap group border-transparent text-gray-500 hover:text-orange-600 hover:border-orange-300"
                        >
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                </svg>
                                My Submissions
                            </span>
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="w-full">
                    <!-- Submit Trip Form Panel -->
                    <div id="submit" class="w-full">
                        <!-- Existing submission form content goes here -->
                        <div class="max-w-3xl mx-auto p-8">
                            @if(session('success'))
                                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                                    {{ session('success') }}
                                </div>
                            @endif
    
                            @if(session('error'))
                                <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
                                    {{ session('error') }}
                                </div>
                            @endif
    
                            @if ($errors->any())
                                <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- Form header -->
                            <div class="mb-8">
                                <h3 class="text-2xl font-bold text-orange-800 mb-2">Open Trip Application Form</h3>
                                <p class="text-orange-700/80">
                                    Thank you for your interest in organizing an open trip! Please provide complete details to help participants understand your trip better.
                                </p>
                            </div>
    
                            <form method="POST" action="{{ route('trip.store') }}" class="space-y-8" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Basic Trip Information -->
                                <div class="space-y-4">
                                    <h4 class="text-lg font-semibold text-orange-800">Trip Details</h4>
                                    
                                    <div>
                                        <label for="trip_name" class="block text-sm font-medium text-orange-700">Trip Name</label>
                                        <input type="text" name="trip_name" id="trip_name" 
                                                class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                        transition duration-200 ease-in-out
                                                        focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                        hover:border-orange-300"
                                                value="{{ old('trip_name') }}"
                                                required>
                                            @error('trip_name')
                                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                    </div>
    
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-orange-700">Trip Description</label>
                                        <textarea name="description" id="description" rows="4" 
                                                    class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                            transition duration-200 ease-in-out
                                                            focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                            hover:border-orange-300"
                                                    required>{{ old('description') }}</textarea>
                                                    @error('trip_name')
                                                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                                    @enderror
                                    </div>
                                </div>
                                
                                <!-- Image Upload Section -->
                                <div class="space-y-4">
                                    <label class="block text-sm font-medium text-orange-700">
                                        Upload Trip Images (Maximum 5 photos)
                                    </label>
                                    <div 
                                        class="mt-1 flex flex-col items-center justify-center w-full h-64 px-4 transition border-2 border-orange-300 border-dashed rounded-lg appearance-none cursor-pointer hover:border-orange-400 focus:outline-none"
                                        id="dropzone"
                                        onclick="document.getElementById('images').click()"
                                    >
                                        <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="mt-2 text-base text-orange-500">Click to upload or drag and drop</p>
                                        <p class="text-sm text-orange-500/80">PNG, JPG, GIF up to 10MB each</p>
                                    </div>
                                    <input type="file" id="images" name="images[]" class="hidden" multiple accept="image/*" onchange="handleFiles(this.files)">
                                    <div id="imagePreviewContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4"></div>
                                    <p class="text-sm text-orange-500" id="imageCount">0 of 5 images selected</p>
                                    @error('images')
                                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
    
                                <!-- Schedule Information -->
                                <div class="space-y-4">
                                    <h4 class="text-lg font-semibold text-orange-800">Schedule & Location</h4>
                                
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="start_date" class="block text-sm font-medium text-orange-700">Start Date</label>
                                            <input type="date" name="start_date" id="start_date" 
                                                class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                        transition duration-200 ease-in-out
                                                        focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                        hover:border-orange-300"
                                                value="{{ old('start_date') }}" 
                                                required>
                                            @error('start_date')
                                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                
                                        <div>
                                            <label for="end_date" class="block text-sm font-medium text-orange-700">End Date</label>
                                            <input type="date" name="end_date" id="end_date" 
                                                class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                        transition duration-200 ease-in-out
                                                        focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                        hover:border-orange-300"
                                                value="{{ old('end_date') }}" 
                                                required>
                                            @error('end_date')
                                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                
                                    <!-- City Section -->
                                    <div class="mt-6">
                                        <label for="city" class="block text-sm font-medium text-orange-700">City</label>
                                        <div class="relative">
                                            <input 
                                                type="text" 
                                                name="city" 
                                                id="city" 
                                                class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                    transition duration-200 ease-in-out
                                                    focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                    hover:border-orange-300"
                                                placeholder="Enter city and province (e.g., Bandung, West Java)" 
                                                value="{{ old('city') }}" 
                                                autocomplete="off"
                                                required
                                            >
                                            <p class="mt-1 text-xs text-gray-500">
                                                Please enter both the city and province for accurate submission.
                                            </p>
                                            @error('city')
                                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                
                                    <!-- Full Address -->
                                    <div class="mt-6">
                                        <label for="address" class="block text-sm font-medium text-orange-700">Full Address</label>
                                        <textarea 
                                            name="address" 
                                            id="address" 
                                            rows="3" 
                                            class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                transition duration-200 ease-in-out
                                                focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                hover:border-orange-300"
                                            placeholder="Enter the complete address for the destination."
                                            required
                                        >{{ old('address') }}</textarea>
                                        <p class="mt-1 text-xs text-orange-500/80">This will be used to determine the map marker position.</p>
                                        @error('address')
                                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
    
                                <!-- Communication Channels -->
                                <div class="space-y-4">
                                    <h4 class="text-lg font-semibold text-orange-800">Communication</h4>
                                    
                                    <div>
                                        <label for="whatsapp_group" class="block text-sm font-medium text-orange-700">WhatsApp Group Link</label>
                                        <input type="url" name="whatsapp_group" id="whatsapp_group" 
                                            class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                    transition duration-200 ease-in-out
                                                    focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                    hover:border-orange-300"
                                            value="{{ old('whatsapp_group') }}" 
                                            required>
                                        @error('whatsapp_group')
                                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
    
                                    <div class="mt-6">
                                        <label for="social_media" class="block text-sm font-medium text-orange-700">Social Media Tags</label>
                                        <input 
                                            type="text" 
                                            name="social_media" 
                                            id="social_media" 
                                            placeholder="e.g., #AdventureTrip #Hiking" 
                                            class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                transition duration-200 ease-in-out
                                                focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                hover:border-orange-300"
                                            value="{{ old('social_media') }}"
                                        >
                                        @error('social_media')
                                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
    
                                <!-- Payment Information -->
                                <div class="space-y-4">
                                    <h4 class="text-lg font-semibold text-orange-800">Payment Details</h4>
                                
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="price" class="block text-sm font-medium text-orange-700">Estimate Price</label>
                                            <input 
                                                type="number" 
                                                name="price" 
                                                id="price" 
                                                class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                    transition duration-200 ease-in-out
                                                    focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                    hover:border-orange-300"
                                                value="{{ old('price') }}" 
                                                required
                                            >
                                            @error('price')
                                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                
                                        <div>
                                            <label for="capacity" class="block text-sm font-medium text-orange-700">Maximum Capacity</label>
                                            <input 
                                                type="number" 
                                                name="capacity" 
                                                id="capacity" 
                                                class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                    transition duration-200 ease-in-out
                                                    focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                    hover:border-orange-300"
                                                value="{{ old('capacity') }}" 
                                                required
                                            >
                                            @error('capacity')
                                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
    
                                <!-- Additional Information -->
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-orange-700 mt-3">Additional Notes</label>
                                    <textarea 
                                        name="notes" 
                                        id="notes" 
                                        rows="3" 
                                        placeholder="Any additional information for participants" 
                                        class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                            transition duration-200 ease-in-out
                                            focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                            hover:border-orange-300"
                                    >{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
    
                                <!-- KTP Upload -->
                                <div class="mt-6">
                                    <label for="ktp" class="block text-sm font-medium text-orange-700">Upload KTP (ID Card)</label>
                                    <div class="relative">
                                        <input 
                                            type="file" 
                                            name="ktp" 
                                            id="ktp" 
                                            accept="image/*" 
                                            required
                                            class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                transition duration-200 ease-in-out
                                                focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                hover:border-orange-300"
                                        >
                                        <p class="mt-1 text-xs text-orange-500/80">JPG, PNG, or PDF. Maximum 2MB.</p>
                                        @error('ktp')
                                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
    
                                <!-- Terms and Submit -->
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="terms" id="terms" value="1" required
                                            class="h-4 w-4 rounded border-orange-300 text-orange-500 
                                                    focus:ring-orange-200">
                                        <label for="terms" class="ml-2 block text-sm text-orange-700">
                                            I have read and agree to the ConnecTrip terms and conditions for trip organizers
                                        </label>
                                    </div>
    
                                    <button type="submit" 
                                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg 
                                                shadow-sm text-sm font-medium text-white bg-orange-600 
                                                transition duration-200 ease-in-out
                                                hover:bg-orange-700 focus:outline-none focus:ring-2 
                                                focus:ring-offset-2 focus:ring-orange-500">
                                        Submit Trip
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- My Submissions Panel -->
                    <div id="submissions" class="hidden w-full">
                        <div class="p-8">
                            <!-- Your existing submissions table -->
                            @if($userTrips->isEmpty())
                                <div class="bg-white/70 rounded-xl p-8 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <p class="mt-4 text-gray-600">You haven't submitted any trips yet.</p>
                                    <a href="#submit" class="mt-4 inline-block text-orange-600 hover:text-orange-700" onclick="switchTab('submit')">
                                        Submit your first trip →
                                    </a>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead>
                                            <tr class="bg-orange-100/50 text-left">
                                                <th class="px-6 py-4 rounded-l-lg text-orange-800 font-semibold">Trip Details</th>
                                                <th class="px-6 py-4 text-orange-800 font-semibold">Date</th>
                                                <th class="px-6 py-4 text-orange-800 font-semibold">Status</th>
                                                <th class="px-6 py-4 rounded-r-lg text-orange-800 font-semibold">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-orange-100">
                                            @foreach($userTrips as $trip)
                                                <tr class="bg-white/70 hover:bg-orange-50/50 transition-colors duration-200">
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-4">
                                                            <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0">
                                                                <img class="w-full h-full object-cover" 
                                                                    src="{{ $trip->images->isNotEmpty() 
                                                                        ? asset('storage/' . $trip->images->first()->photo_path)
                                                                        : asset('images/default-trip.jpg') }}" 
                                                                    alt="{{ $trip->trip_name }}">
                                                            </div>
                                                            <div>
                                                                <h4 class="font-medium text-gray-900">{{ $trip->trip_name }}</h4>
                                                                <p class="text-sm text-gray-500">{{ $trip->city }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm text-gray-600">
                                                            <div class="flex items-center gap-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                                {{ $trip->formatted_start_date }} - {{ $trip->formatted_end_date }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                            {{ $trip->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                                            ($trip->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                                                'bg-yellow-100 text-yellow-800') }}">
                                                            {{ ucfirst($trip->status) }}
                                                        </span>
                                                        @if($trip->status === 'rejected' && $trip->rejection_reason)
                                                            <div class="mt-2 text-sm text-red-600">
                                                                {{ $trip->rejection_reason }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <a href="{{ route('trips.show', $trip->id) }}" 
                                                            class="inline-flex items-center gap-2 text-orange-600 hover:text-orange-700 transition-colors">
                                                            View Details
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                            </svg>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function switchTab(tabId) {
            // Get all tab buttons and panels
            const tabs = document.querySelectorAll('[data-tab]');
            const panels = document.querySelectorAll('#submit, #submissions');
            
            // Hide all panels and reset all tabs
            panels.forEach(panel => {
                if (panel.id === tabId) {
                    panel.classList.remove('hidden');
                } else {
                    panel.classList.add('hidden');
                }
            });
            
            // Update tab styles
            tabs.forEach(tab => {
                if (tab.dataset.tab === tabId) {
                    tab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-orange-600', 'hover:border-orange-300');
                    tab.classList.add('border-orange-500', 'text-orange-600');
                } else {
                    tab.classList.add('border-transparent', 'text-gray-500', 'hover:text-orange-600', 'hover:border-orange-300');
                    tab.classList.remove('border-orange-500', 'text-orange-600');
                }
            });
        }
        const dropzone = document.getElementById('dropzone');
        const input = document.getElementById('images');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const imageCount = document.getElementById('imageCount');
        const maxImages = 5;

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight dropzone when dragging over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropzone.classList.add('border-orange-500', 'bg-orange-50');
        }

        function unhighlight(e) {
            dropzone.classList.remove('border-orange-500', 'bg-orange-50');
        }

        // Handle dropped files
        dropzone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        function handleFiles(files) {
            if (files.length > maxImages) {
                alert(`Maximum ${maxImages} images allowed`);
                return;
            }

            previewContainer.innerHTML = '';
            Array.from(files).forEach(previewFile);
            imageCount.textContent = `${files.length} of ${maxImages} images selected`;
        }

        function previewFile(file) {
            if (!file.type.startsWith('image/')) return;
            
            const reader = new FileReader();
            reader.readAsDataURL(file);
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg" />
                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                        <p class="text-white text-xs px-2 text-center truncate">${file.name}</p>
                    </div>
                `;
                previewContainer.appendChild(div);
            };
        }
    </script>
</x-app-layout>