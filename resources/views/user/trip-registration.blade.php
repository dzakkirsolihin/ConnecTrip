<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Registration') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white">
                  <div class="mb-8">
                      <h3 class="text-2xl font-bold text-gray-900 mb-2">Open Trip Participation Form</h3>
                      <p class="text-gray-600">
                          Welcome to our open trip! To facilitate preparation and ensure your comfort during the trip, please fill out this form completely and correctly.
                      </p>
                  </div>

                  <form class="space-y-6">
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                          <div>
                              <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                              <input type="text" name="first_name" id="first_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                          </div>

                          <div>
                              <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                              <input type="text" name="last_name" id="last_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                          </div>
                      </div>

                      <div>
                          <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                          <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"></textarea>
                      </div>

                      <div>
                          <label for="whatsapp" class="block text-sm font-medium text-gray-700">WhatsApp Number</label>
                          <input type="tel" name="whatsapp" id="whatsapp" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                      </div>

                      <div>
                          <label for="emergency_contact" class="block text-sm font-medium text-gray-700">Emergency Contact Number</label>
                          <input type="tel" name="emergency_contact" id="emergency_contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                      </div>

                      <div>
                          <label for="medical_history" class="block text-sm font-medium text-gray-700">Medical History</label>
                          <textarea name="medical_history" id="medical_history" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"></textarea>
                      </div>

                      <div>
                          <label for="payment_info" class="block text-sm font-medium text-gray-700">Payment Information</label>
                          <textarea name="payment_info" id="payment_info" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"></textarea>
                      </div>

                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                          <div>
                              <label for="instagram" class="block text-sm font-medium text-gray-700">Instagram Account</label>
                              <input type="text" name="instagram" id="instagram" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                          </div>

                          <div>
                              <label for="twitter" class="block text-sm font-medium text-gray-700">Twitter Account</label>
                              <input type="text" name="twitter" id="twitter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                          </div>
                      </div>

                      <div>
                          <label class="block text-sm font-medium text-gray-700 mb-2">Privacy Setting</label>
                          <div class="flex gap-4">
                              <label class="inline-flex items-center">
                                  <input type="radio" name="privacy" value="public" class="form-radio text-orange-500">
                                  <span class="ml-2">Public</span>
                              </label>
                              <label class="inline-flex items-center">
                                  <input type="radio" name="privacy" value="private" class="form-radio text-orange-500">
                                  <span class="ml-2">Private</span>
                              </label>
                          </div>
                      </div>

                      <div>
                          <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                          <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"></textarea>
                      </div>

                      <div class="flex items-center">
                          <input type="checkbox" name="terms" id="terms" class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                          <label for="terms" class="ml-2 block text-sm text-gray-700">
                              I have read and agree to the ConnecTrip terms and conditions
                          </label>
                      </div>

                      <div>
                          <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                              Submit Registration
                          </button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>