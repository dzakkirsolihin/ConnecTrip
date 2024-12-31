<x-admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trip Proposals Management') }}
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
                                'pending' => 'Pending Approval',
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

            <!-- Proposals Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($proposals as $proposal)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $proposal->title }}</h3>
                                    <p class="text-sm text-gray-500">by {{ $proposal->user->name }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $proposal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($proposal->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                        'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($proposal->status) }}
                                </span>
                            </div>

                            <div class="space-y-2">
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Destination:</span> {{ $proposal->destination }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Date:</span> 
                                    {{ $proposal->start_date->format('M d, Y') }} - {{ $proposal->end_date->format('M d, Y') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Price:</span> 
                                    Rp {{ number_format($proposal->price_per_person, 0, ',', '.') }}/person
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Max Participants:</span> {{ $proposal->max_participants }}
                                </p>
                            </div>

                            @if($proposal->status === 'pending')
                                <div class="pt-4 flex space-x-2">
                                    <form action="{{ route('admin.proposals.update-status', $proposal) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                            Approve
                                        </button>
                                    </form>
                                    
                                    <button onclick="openRejectModal({{ $proposal->id }})" 
                                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                        Reject
                                    </button>
                                </div>
                            @endif

                            @if($proposal->status === 'rejected' && $proposal->rejection_reason)
                                <div class="mt-4 p-3 bg-red-50 rounded-md">
                                    <p class="text-sm text-red-700">
                                        <span class="font-medium">Rejection reason:</span> {{ $proposal->rejection_reason }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            No trip proposals found for this status.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $proposals->links() }}
            </div>
        </div>
        <!-- Rejection Modal -->
        <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900">Reject Trip Proposal</h3>
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
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Make the functions globally available
            window.openRejectModal = function(proposalId) {
                const modal = document.getElementById('rejectModal');
                const form = document.getElementById('rejectForm');
                if (modal && form) {
                    form.action = `/admin/proposals/${proposalId}/update-status`;
                    modal.classList.remove('hidden');
                }
            };

            window.closeRejectModal = function() {
                const modal = document.getElementById('rejectModal');
                if (modal) {
                    modal.classList.add('hidden');
                }
            };

            // Add click event listener to close modal when clicking outside
            const modal = document.getElementById('rejectModal');
            if (modal) {
                modal.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        closeRejectModal();
                    }
                });
            }
        });
    </script>
    @endpush
</x-admin>