<div>
    <!-- Bulk Actions Bar -->
    @if(count($selectedPermits) > 0)
    <div class="bg-blue-600 text-white rounded-xl shadow-lg p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-semibold">{{ count($selectedPermits) }} permit(s) selected</span>
            </div>
            <div class="flex gap-3">
                <button onclick="openBulkReminderModal({{ json_encode($selectedPermits) }})" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Send Reminders
                </button>
                <button onclick="bulkDelete({{ json_encode($selectedPermits) }})" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Selected
                </button>
                <button wire:click="clearSelection" class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white font-semibold rounded-lg transition duration-200">
                    Clear Selection
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Search & Filter Section -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </label>
                    <input type="text" wire:model.live.debounce.300ms="search"
                           placeholder="Search by permit name, number, boss name, or email..."
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border">
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Status
                    </label>
                    <select wire:model.live="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                        <option value="renewed">Renewed</option>
                    </select>
                </div>

                <!-- Division Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Division
                    </label>
                    <select wire:model.live="division" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border">
                        <option value="Perencanaan Hutan">Perencanaan Hutan</option>
                        <option value="Sertifikasi & Studi (Kajian)">Sertifikasi & Studi (Kajian)</option>
                        <option value="SDM & Umum">SDM & Umum</option>
                        <option value="Lingkungan">Lingkungan</option>
                        <option value="K3">K3</option>
                        <option value="Sosial">Sosial</option>
                        <option value="Pengolahan Hasil Hutan">Pengolahan Hasil Hutan</option>
                        <option value="Penelitian dan Pengembangan">Penelitian dan Pengembangan</option>
                        <option value="Sistem Informasi (IT)">Sistem Informasi (IT)</option>
                    </select>
                </div>

                <!-- Expiry Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Expiry
                    </label>
                    <select wire:model.live="expiry" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border">
                        <option value="">All Expiry</option>
                        <option value="expired">Already Expired</option>
                        <option value="30_days">Next 30 Days</option>
                        <option value="60_days">Next 60 Days</option>
                        <option value="90_days">Next 90 Days</option>
                        <option value="180_days">Next 180 Days</option>
                    </select>
                </div>
            </div>

            <!-- Sort Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                        </svg>
                        Sort By
                    </label>
                    <select wire:model.live="sortBy" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border">
                        <option value="expiry_date">Expiry Date</option>
                        <option value="issue_date">Issue Date</option>
                        <option value="permit_name">Permit Name</option>
                        <option value="created_at">Created Date</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                    <select wire:model.live="sortOrder" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>

                <div class="flex items-end lg:col-span-2">
                    <button wire:click="clearFilters" class="w-full bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="mb-4 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
        <p class="text-sm text-blue-800 flex items-center">
            <svg class="animate-spin h-5 w-5 mr-2 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Loading permits...
        </p>
    </div>

    <!-- Select All Checkbox -->
    @if($permits->isNotEmpty())
    <div class="bg-white rounded-lg shadow-md p-4 mb-4">
        <label class="flex items-center cursor-pointer">
            <input type="checkbox" wire:model.live="selectAll" class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
            <span class="ml-3 text-sm font-medium text-gray-700">Select All Permits ({{ $permits->count() }})</span>
        </label>
    </div>
    @endif

    <!-- Results Count -->
    @if($search || $status !== 'all' || $expiry)
        <div class="mb-4 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
            <p class="text-sm text-blue-800">
                <strong>{{ $permits->count() }}</strong> permit(s) found
                @if($search)
                    matching "<strong>{{ $search }}</strong>"
                @endif
            </p>
        </div>
    @endif

    <!-- Permits List -->
    @if($permits->isEmpty())
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No permits found</h3>
                <p class="text-gray-600 mb-8">
                    @if($search || $status !== 'all' || $expiry)
                        Try adjusting your filters or search query.
                    @else
                        Get started by creating your first permit to track expiration dates.
                    @endif
                </p>
                @if($search || $status !== 'all' || $expiry)
                    <button wire:click="clearFilters" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition duration-200">
                        Clear Filters
                    </button>
                @else
                    <a href="{{ route('permits.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Your First Permit
                    </a>
                @endif
            </div>
        </div>
    @else
        <div class="space-y-4">
            @foreach($permits as $permit)
                @php
                    $daysUntilExpiry = $permit->daysUntilExpiry();
                    $statusColor = 'gray';
                    $statusText = 'Active';
                    $statusIcon = '✓';
                    $cardBorder = 'border-l-4 border-green-500';

                    if ($permit->isExpired()) {
                        $statusColor = 'red';
                        $statusText = 'Expired';
                        $statusIcon = '✕';
                        $cardBorder = 'border-l-4 border-red-500';
                    } elseif ($daysUntilExpiry <= 30) {
                        $statusColor = 'red';
                        $statusText = 'Critical';
                        $statusIcon = '⚠';
                        $cardBorder = 'border-l-4 border-red-500';
                    } elseif ($daysUntilExpiry <= 90) {
                        $statusColor = 'yellow';
                        $statusText = 'Warning';
                        $statusIcon = '⚡';
                        $cardBorder = 'border-l-4 border-yellow-500';
                    } elseif ($daysUntilExpiry <= 180) {
                        $statusColor = 'blue';
                        $statusText = 'Upcoming';
                        $statusIcon = '📅';
                        $cardBorder = 'border-l-4 border-blue-500';
                    }
                @endphp

                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 {{ $cardBorder }} overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <!-- Checkbox + Permit Info -->
                            <div class="flex items-start gap-4 flex-1 min-w-0">
                                <!-- Checkbox -->
                                <div class="flex-shrink-0 mt-3">
                                    <input type="checkbox"
                                           wire:model.live="selectedPermits"
                                           value="{{ $permit->id }}"
                                           class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                                </div>

                                <div class="flex items-start gap-3 flex-1">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $permit->permit_name }}</h3>
                                        @if($permit->permit_number)
                                            <p class="text-sm text-gray-600 mb-1">{{ $permit->permit_number }}</p>
                                        @else
                                            <p class="text-sm text-gray-400 italic mb-1">No permit number</p>
                                        @endif
                                         <!-- Division Badge -->
                                        @if($permit->division)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-indigo-100 text-indigo-800 mb-2">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                {{ $permit->division }}
                                            </span>
                                        @endif

                                        <!-- Boss Info -->
                                        <div class="space-y-1">
                                            <div class="flex items-center text-sm text-gray-700 mb-1">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                <span class="font-medium">{{ $permit->boss_name }}</span>
                                            </div>

                                            <div class="flex items-start text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2 mt-0.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                <div class="flex-1">
                                                    <div>{{ $permit->boss_email }}</div>
                                                    @if($permit->boss_email_2)
                                                        <div class="text-xs mt-0.5">{{ $permit->boss_email_2 }}</div>
                                                    @endif
                                                    @if($permit->division_email)
                                                        <div class="text-xs text-indigo-600 mt-0.5">📧 {{ $permit->division_email }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dates Section -->
                            <div class="flex-shrink-0 bg-gray-50 rounded-lg p-4 min-w-[200px]">
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Issue Date:</span>
                                        <span class="font-semibold text-gray-900">{{ $permit->issue_date->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Expiry Date:</span>
                                        <span class="font-semibold text-{{ $statusColor }}-600">{{ $permit->expiry_date->format('d M Y') }}</span>
                                    </div>
                                    <div class="pt-2 border-t border-gray-200">
                                        <div class="flex items-center justify-center">
                                            <span class="text-2xl font-bold text-{{ $statusColor }}-600">{{ abs($daysUntilExpiry) }}</span>
                                            <span class="text-sm text-gray-600 ml-2">days {{ $daysUntilExpiry < 0 ? 'overdue' : 'left' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Actions -->
                            <div class="flex-shrink-0 flex flex-col items-end gap-3 min-w-[180px]">
                                <!-- Status Badge -->
                                <div class="w-full">
                                    <span class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-bold rounded-lg bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800 border border-{{ $statusColor }}-200">
                                        <span class="mr-1">{{ $statusIcon }}</span> {{ $statusText }}
                                    </span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2 w-full">
                                    <a href="{{ route('permits.edit', $permit) }}"
                                       class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <button onclick="openReminderModal({{ $permit->id }}, '{{ $permit->permit_name }}')"
                                            class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Remind
                                    </button>
                                </div>

                                <!-- History & Delete Buttons -->
                                <div class="flex gap-2 w-full">
                                    <a href="{{ route('permits.history', $permit) }}"
                                       class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        History
                                    </a>
                                    <form action="{{ route('permits.destroy', $permit) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this permit?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Description (if exists) -->
                        @if($permit->description)
                            <div class="mt-4 pt-4 border-t border-gray-200 ml
                            <div class="mt-4 pt-4 border-t border-gray-200 ml-16">
                                <p class="text-sm text-gray-600 italic">{{ $permit->description }}</p>
                            </div>
                        @endif

                        <!-- Reminder Categories Badge -->
                        @if($permit->reminder_categories && count($permit->reminder_categories) > 0)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-xs font-medium text-gray-600 mb-2">Reminder Categories:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($permit->reminder_categories as $category)
                                        @if($category === '6_months')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                📅 6 Months
                                            </span>
                                        @elseif($category === '3_months')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                ⏰ 3 Months
                                            </span>
                                        @elseif($category === '1_month')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                ⚠️ 1 Month
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                         <!-- Document Badge - ADD THIS HERE -->
                        @if($permit->hasDocument())
                            <div class="mt-3 ml-16">
                                <a href="{{ $permit->getDocumentUrl() }}" target="_blank"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    📎 {{ $permit->document_original_name }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
