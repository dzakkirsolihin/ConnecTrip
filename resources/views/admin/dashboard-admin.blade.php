<x-admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trip Submissions Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Status Filters -->
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex justify-between items-center">
                    <div class="flex space-x-4">
                        @php
                            $statuses = [
                                'all' => 'All Submissions',
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected'
                            ];
                        @endphp
                        
                        @foreach ($statuses as $key => $label)
                            <a href="{{ route('admin.dashboard', ['status' => $key]) }}"
                               class="px-4 py-2 rounded-md {{ $status === $key ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ $label }}
                                <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $status === $key ? 'bg-blue-500' : 'bg-gray-200' }}">
                                    {{ $counts[$key] }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Trip Submissions Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trip Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organizer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($submissions as $submission)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover" 
                                                         src="{{ asset('storage/' . ($submission->images->first()?->photo_path ?? 'images/default-trip.jpg')) }}" 
                                                         alt="{{ $submission->trip_name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $submission->trip_name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $submission->city }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ optional($submission->user)->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $submission->start_date->format('M d, Y') }} - {{ $submission->end_date->format('M d, Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $submission->duration }} days
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $submission->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                                   ($submission->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                                    'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($submission->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            Rp {{ number_format($submission->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                @if($submission->status === 'pending')
                                                    <form action="{{ route('admin.trips.update-status', $submission) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" 
                                                                class="bg-green-600 text-white px-3 py-1 rounded-md hover:bg-green-700 transition-colors">
                                                            Approve
                                                        </button>
                                                    </form>
                                                    
                                                    <button onclick="openRejectModal('{{ $submission->id }}')" 
                                                            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700 transition-colors">
                                                        Reject
                                                    </button>
                                                @endif
                                                
                                                <!-- Tambahkan tombol View Details untuk semua status -->
                                                <button onclick="openTripDetailsModal('{{ $submission->id }}')" 
                                                        class="text-blue-600 hover:text-blue-900">
                                                    View Details
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No trip submissions found for this status.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $submissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trip Details Modal -->
    <div id="tripDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-3/4 shadow-lg rounded-md bg-white max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-2xl font-bold text-gray-900" id="modalTripName"></h3>
                <button onclick="closeTripDetailsModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
    
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Trip Images Section -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold">Trip Images</h4>
                    <div id="tripImagesContainer" class="grid grid-cols-2 gap-4">
                        <!-- Images will be inserted here dynamically -->
                    </div>
                </div>
    
                <!-- Trip Details Section -->
                <div class="space-y-4">
                    <div>
                        <h4 class="text-lg font-semibold">Location Details</h4>
                        <p class="text-gray-600" id="modalCity"></p>
                        <p class="text-gray-600" id="modalAddress"></p>
                    </div>
    
                    <div>
                        <h4 class="text-lg font-semibold">Trip Information</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Date Range</p>
                                <p class="text-gray-900" id="modalDateRange"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Price</p>
                                <p class="text-gray-900" id="modalPrice"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Capacity</p>
                                <p class="text-gray-900" id="modalCapacity"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="text-gray-900" id="modalStatus"></p>
                            </div>
                        </div>
                    </div>
    
                    <div>
                        <h4 class="text-lg font-semibold">Description</h4>
                        <p class="text-gray-600" id="modalDescription"></p>
                    </div>
    
                    <div>
                        <h4 class="text-lg font-semibold">Contact Information</h4>
                        <div class="space-y-2">
                            <p class="text-gray-600">WhatsApp Group: <a id="modalWhatsApp" href="" target="_blank" class="text-blue-600 hover:underline"></a></p>
                            <p class="text-gray-600">Social Media: <span id="modalSocialMedia"></span></p>
                        </div>
                    </div>
    
                    <div>
                        <h4 class="text-lg font-semibold">Additional Notes</h4>
                        <p class="text-gray-600" id="modalNotes"></p>
                    </div>
    
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold">Verification Documents</h4>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">KTP Document</p>
                            <a id="modalKTP" href="" target="_blank" class="text-blue-600 hover:underline">View KTP Document</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Reject Trip Submission</h3>
                <form id="rejectForm" action="" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    
                    <div class="mt-2">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                        <textarea
                            name="rejection_reason"
                            id="rejection_reason"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        ></textarea>
                    </div>

                    <div class="mt-4 flex justify-end space-x-3">
                        <button
                            type="button"
                            onclick="closeRejectModal()"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                        >
                            Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        async function openTripDetailsModal(tripId) {
            const modal = document.getElementById('tripDetailsModal');
            if (!modal) return;

            try {
                const response = await fetch(`/admin/trips/${tripId}/details`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                
                // Update modal content
                document.getElementById('modalTripName').textContent = data.trip_name;
                document.getElementById('modalCity').textContent = data.city;
                document.getElementById('modalAddress').textContent = data.address;
                document.getElementById('modalDateRange').textContent = `${data.start_date} - ${data.end_date}`;
                document.getElementById('modalPrice').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(data.price)}`;
                document.getElementById('modalCapacity').textContent = data.capacity;
                document.getElementById('modalDescription').textContent = data.description;
                document.getElementById('modalWhatsApp').href = data.whatsapp_group;
                document.getElementById('modalWhatsApp').textContent = data.whatsapp_group;
                document.getElementById('modalSocialMedia').textContent = data.social_media || 'Not provided';
                document.getElementById('modalNotes').textContent = data.notes || 'No additional notes';
                document.getElementById('modalStatus').textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                document.getElementById('modalKTP').href = `/storage/${data.ktp_path}`;

                // Handle images
                const imagesContainer = document.getElementById('tripImagesContainer');
                imagesContainer.innerHTML = '';
                
                if (data.images && data.images.length > 0) {
                    data.images.forEach(image => {
                        const imgDiv = document.createElement('div');
                        imgDiv.className = 'aspect-w-16 aspect-h-9';
                        imgDiv.innerHTML = `
                            <img src="/storage/${image.photo_path}" 
                                alt="Trip Image" 
                                class="object-cover rounded-lg w-full h-full">
                        `;
                        imagesContainer.appendChild(imgDiv);
                    });
                } else {
                    imagesContainer.innerHTML = '<p class="text-gray-500">No images available</p>';
                }

                modal.classList.remove('hidden');
            } catch (error) {
                console.error('Error fetching trip details:', error);
                alert('Gagal memuat detail perjalanan. Silakan coba lagi.');
            }
        }

        function closeTripDetailsModal() {
            const modal = document.getElementById('tripDetailsModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Close modal when clicking outside
        document.getElementById('tripDetailsModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeTripDetailsModal();
            }
        });

        function openRejectModal(submissionId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            if (modal && form) {
                form.action = `/admin/trips/${submissionId}/status`;
                modal.classList.remove('hidden');
            }
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            if (modal) {
                modal.classList.add('hidden');
                document.getElementById('rejection_reason').value = '';
            }
        }

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeRejectModal();
            }
        });
    </script>
    @endpush
</x-admin>