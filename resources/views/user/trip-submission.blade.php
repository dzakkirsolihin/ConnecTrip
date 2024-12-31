<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-orange-800 leading-tight">
            {{ __('Trip Submission') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-orange-50/50 overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-8">
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
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-orange-800 mb-2">Open Trip Application Form</h3>
                        <p class="text-orange-700/80">
                            Thank you for your interest in organizing an open trip! Please provide complete details to help participants understand your trip better.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('trip.store') }}" class="space-y-6" enctype="multipart/form-data">
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
                                       required>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-orange-700">Trip Description</label>
                                <textarea name="description" id="description" rows="4" 
                                          class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                 transition duration-200 ease-in-out
                                                 focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                 hover:border-orange-300"
                                          required></textarea>
                            </div>
                        </div>

                        <!-- Trip Images -->
                        <div class="py-12">
                            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-orange-50/50 overflow-hidden shadow-lg sm:rounded-xl">
                                    <div class="p-8">
                                        <div class="mb-8">
                                            <h3 class="text-2xl font-bold text-orange-800 mb-2">Open Trip Application Form</h3>
                                            <p class="text-orange-700/80">
                                                Thank you for your interest in organizing an open trip! Please provide complete details to help participants understand your trip better.
                                            </p>
                                        </div>
                                            <!-- Image Upload Section -->
                                            <div class="space-y-4">
                                                <h4 class="text-lg font-semibold text-orange-800">Trip Images</h4>
                                                
                                                <div class="space-y-2">
                                                    <label class="block text-sm font-medium text-orange-700">
                                                        Upload Trip Images (Maximum 5 photos)
                                                    </label>
                                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-orange-300 border-dashed rounded-lg hover:border-orange-400 transition-colors duration-200">
                                                        <div class="space-y-1 text-center">
                                                            <svg class="mx-auto h-12 w-12 text-orange-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                            <div class="flex text-sm text-orange-600">
                                                                <label for="images" class="relative cursor-pointer rounded-md font-medium text-orange-600 hover:text-orange-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                                                    <span>Upload files</span>
                                                                    <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*" onchange="previewImages(event)">
                                                                </label>
                                                                <p class="pl-1">or drag and drop</p>
                                                            </div>
                                                            <p class="text-xs text-orange-500">
                                                                PNG, JPG, GIF up to 10MB each
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- Image Preview Container -->
                                                    <div id="imagePreviewContainer" class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4"></div>
                                                    <p class="text-xs text-orange-500 mt-2" id="imageCount">0 of 5 images selected</p>
                                                </div>
                                            </div>
                    
                                            <!-- Previous form fields continue from here -->
                                    </div>
                                </div>
                            </div>
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
                                           required>
                                </div>

                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-orange-700">End Date</label>
                                    <input type="date" name="end_date" id="end_date" 
                                           class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                  transition duration-200 ease-in-out
                                                  focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                  hover:border-orange-300"
                                           required>
                                </div>
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-orange-700">Address</label>
                                <input type="text" name="address" id="address" 
                                       class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                              transition duration-200 ease-in-out
                                              focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                              hover:border-orange-300"
                                       required>
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
                                       required>
                            </div>

                            <div>
                                <label for="social_media" class="block text-sm font-medium text-orange-700">Social Media Tags</label>
                                <input type="text" name="social_media" id="social_media" 
                                       placeholder="e.g., #AdventureTrip #Hiking" 
                                       class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                              transition duration-200 ease-in-out
                                              focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                              hover:border-orange-300">
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-orange-800">Payment Details</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-orange-700">Estimate Price</label>
                                    <input type="number" name="price" id="price" 
                                           class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                  transition duration-200 ease-in-out
                                                  focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                  hover:border-orange-300"
                                           required>
                                </div>

                                <div>
                                    <label for="capacity" class="block text-sm font-medium text-orange-700">Maximum Capacity</label>
                                    <input type="number" name="capacity" id="capacity" 
                                           class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                  transition duration-200 ease-in-out
                                                  focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                  hover:border-orange-300"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-orange-700 mt-3">Additional Notes</label>
                            <textarea name="notes" id="notes" rows="3" 
                                      placeholder="Any additional information for participants" 
                                      class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                             transition duration-200 ease-in-out
                                             focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                             hover:border-orange-300"></textarea>
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
        </div>
    </div>
    <script>
        function previewImages(event) {
            const maxImages = 5;
            const files = event.target.files;
            const previewContainer = document.getElementById('imagePreviewContainer');
            const imageCountDisplay = document.getElementById('imageCount');
            
            // Clear previous previews if new selection
            if (files.length > 0) {
                previewContainer.innerHTML = '';
            }

            // Limit file selection to maximum allowed
            if (files.length > maxImages) {
                alert(`You can only upload a maximum of ${maxImages} images.`);
                event.target.value = '';
                return;
            }

            // Update image count display
            imageCountDisplay.textContent = `${files.length} of ${maxImages} images selected`;

            // Create preview for each selected image
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'relative group';
                    preview.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg" />
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                            <p class="text-white text-sm">${file.name}</p>
                        </div>
                    `;
                    previewContainer.appendChild(preview);
                }
                
                reader.readAsDataURL(file);
            });
        }
    </script>
</x-app-layout>