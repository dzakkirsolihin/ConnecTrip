<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-orange-800 leading-tight">
            {{ __('Registration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-orange-50/50 overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-orange-800 mb-2">Open Trip Participation Form</h3>
                        <p class="text-orange-700/80">
                            Welcome to our open trip! Please fill out this form completely to ensure your comfort during the trip.
                        </p>
                    </div>

                    {{-- nanti tambahkan action="{{ route('registration.store', $trip) }}" --}}
                    <form method="POST"  class="space-y-6">
                        @csrf
                        
                        <!-- Personal Information Section -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-orange-800">Personal Information</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-orange-700">First Name</label>
                                    <input type="text" name="first_name" id="first_name" 
                                        class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                transition duration-200 ease-in-out
                                                focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                hover:border-orange-300"
                                        required>
                                </div>

                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-orange-700">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" 
                                        class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                transition duration-200 ease-in-out
                                                focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                hover:border-orange-300"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-orange-800">Contact Information</h4>
                            
                            <div>
                                <label for="address" class="block text-sm font-medium text-orange-700">Address</label>
                                <textarea name="address" id="address" rows="3" 
                                        class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                transition duration-200 ease-in-out
                                                focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                hover:border-orange-300"
                                        required></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="whatsapp" class="block text-sm font-medium text-orange-700">WhatsApp Number</label>
                                    <input type="tel" name="whatsapp" id="whatsapp" 
                                        class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                transition duration-200 ease-in-out
                                                focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                hover:border-orange-300"
                                        required>
                                </div>

                                <div>
                                    <label for="emergency_contact" class="block text-sm font-medium text-orange-700">Emergency Contact</label>
                                    <input type="tel" name="emergency_contact" id="emergency_contact" 
                                        class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                transition duration-200 ease-in-out
                                                focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                hover:border-orange-300"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-orange-800">Additional Information</h4>
                            
                            <div>
                                <label for="medical_history" class="block text-sm font-medium text-orange-700">Medical History</label>
                                <textarea name="medical_history" id="medical_history" rows="3" 
                                        class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                transition duration-200 ease-in-out
                                                focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                hover:border-orange-300"></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="instagram" class="block text-sm font-medium text-orange-700">Instagram Account</label>
                                    <input type="text" name="instagram" id="instagram" 
                                        class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                transition duration-200 ease-in-out
                                                focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                hover:border-orange-300">
                                </div>

                                <div>
                                    <label for="twitter" class="block text-sm font-medium text-orange-700">Twitter Account</label>
                                    <input type="text" name="twitter" id="twitter" 
                                        class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                                transition duration-200 ease-in-out
                                                focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                                hover:border-orange-300">
                                </div>
                            </div>
                        </div>

                        <!-- Privacy Settings -->
                        <div class="space-y-2">
                            <h4 class="text-lg font-semibold text-orange-800">Privacy Settings</h4>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="privacy" value="public" 
                                        class="form-radio text-orange-500 focus:ring-orange-200">
                                    <span class="ml-2 text-orange-700">Public</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="privacy" value="private" 
                                        class="form-radio text-orange-500 focus:ring-orange-200">
                                    <span class="ml-2 text-orange-700">Private</span>
                                </label>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-orange-700">Additional Notes</label>
                            <textarea name="notes" id="notes" rows="3" 
                                    class="mt-1 block w-full rounded-lg border-orange-200 bg-white/70 shadow-sm 
                                            transition duration-200 ease-in-out
                                            focus:border-orange-400 focus:ring focus:ring-orange-200 focus:ring-opacity-50
                                            hover:border-orange-300"></textarea>
                        </div>

                        <!-- Terms and Submit -->
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="terms" id="terms" required
                                    class="h-4 w-4 rounded border-orange-300 text-orange-500 
                                            focus:ring-orange-200">
                                <label for="terms" class="ml-2 block text-sm text-orange-700">
                                    I have read and agree to the ConnecTrip terms and conditions
                                </label>
                            </div>

                            <button type="submit" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg 
                                        shadow-sm text-sm font-medium text-white bg-orange-600 
                                        transition duration-200 ease-in-out
                                        hover:bg-orange-700 focus:outline-none focus:ring-2 
                                        focus:ring-offset-2 focus:ring-orange-500">
                                Submit Registration
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>