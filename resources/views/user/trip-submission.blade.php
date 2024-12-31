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

                    <form method="POST" action="{{ route('trip.store') }}" class="space-y-6">
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
                                <label for="meeting_point" class="block text-sm font-medium text-orange-700">Meeting Point</label>
                                <input type="text" name="meeting_point" id="meeting_point" 
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
                                    <label for="price" class="block text-sm font-medium text-orange-700">Price per Person</label>
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

                            <div>
                                <label for="payment_info" class="block text-sm font-medium text-orange-700">Payment Information</label>
                                <textarea name="payment_info" id="payment_info" rows="3" 
                                          placeholder="Bank account details, payment deadlines, etc." 
                                          class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                 transition duration-200 ease-in-out
                                                 focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                 hover:border-orange-300"
                                          required></textarea>
                            </div>
                        </div>

                        <!-- Visibility Settings -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-orange-800">Trip Visibility</h4>
                            
                            <div class="flex items-center justify-between p-4 rounded-lg bg-white/50 border border-orange-200">
                                <span class="text-sm font-medium text-orange-700">Make this trip public</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_public" value="1" class="sr-only peer" {{ old('is_public') ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer 
                                                peer-checked:after:translate-x-full peer-checked:bg-orange-500
                                                after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                                after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all 
                                                border-none">
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-orange-700">Additional Notes</label>
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
</x-app-layout>