@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Permit List</h2>
            <p class="text-gray-600 mt-2">Monitor and manage all permits with ease</p>
        </div>
        <a href="{{ route('permits.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Permit
        </a>
    </div>
</div>

<!-- Livewire Component -->
<livewire:permit-list />

<!-- Single Reminder Modal -->
<div id="reminderModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 items-center justify-center p-4">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-bold text-gray-900">Send Reminder</h3>
                <button onclick="closeReminderModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
                <p class="text-sm text-blue-800">
                    <strong>Permit:</strong> <span id="permitName" class="font-semibold"></span>
                </p>
            </div>

            <form id="reminderForm" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Select Reminder Type</label>
                    <div class="space-y-2">
                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                            <input type="radio" name="reminder_type" value="6_months" required class="w-4 h-4 text-blue-600">
                            <div class="ml-3">
                                <span class="font-medium text-gray-900">6 Months Notice</span>
                                <p class="text-xs text-gray-600">Early warning notification</p>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                            <input type="radio" name="reminder_type" value="3_months" required class="w-4 h-4 text-blue-600">
                            <div class="ml-3">
                                <span class="font-medium text-gray-900">3 Months Notice</span>
                                <p class="text-xs text-gray-600">Standard reminder</p>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition">
                            <input type="radio" name="reminder_type" value="1_month" required class="w-4 h-4 text-red-600">
                            <div class="ml-3">
                                <span class="font-medium text-red-900">1 Month Notice</span>
                                <p class="text-xs text-red-600">⚠️ Urgent notification</p>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                            <input type="radio" name="reminder_type" value="manual" required class="w-4 h-4 text-blue-600">
                            <div class="ml-3">
                                <span class="font-medium text-gray-900">Custom Manual Reminder</span>
                                <p class="text-xs text-gray-600">General notification</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeReminderModal()"
                            class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-200">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-800 shadow-lg transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Reminder Modal -->
<div id="bulkReminderModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 items-center justify-center p-4">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full transform transition-all">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-bold text-gray-900">Send Bulk Reminders</h3>
                <button onclick="closeBulkReminderModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                <p class="text-sm text-green-800">
                    <strong>Selected Permits:</strong> <span id="bulkSelectedCount" class="font-semibold"></span>
                </p>
                <div id="bulkPermitsList" class="mt-2 text-xs text-green-700 max-h-32 overflow-y-auto"></div>
            </div>

            <form id="bulkReminderForm" method="POST" action="{{ route('permits.bulk-reminder') }}">
                @csrf
                <input type="hidden" name="permit_ids" id="bulkPermitIds">

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Select Reminder Type</label>
                    <div class="space-y-2">
                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                            <input type="radio" name="reminder_type" value="6_months" required class="w-4 h-4 text-blue-600">
                            <div class="ml-3">
                                <span class="font-medium text-gray-900">6 Months Notice</span>
                                <p class="text-xs text-gray-600">Early warning notification</p>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                            <input type="radio" name="reminder_type" value="3_months" required class="w-4 h-4 text-blue-600">
                            <div class="ml-3">
                                <span class="font-medium text-gray-900">3 Months Notice</span>
                                <p class="text-xs text-gray-600">Standard reminder</p>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition">
                            <input type="radio" name="reminder_type" value="1_month" required class="w-4 h-4 text-red-600">
                            <div class="ml-3">
                                <span class="font-medium text-red-900">1 Month Notice</span>
                                <p class="text-xs text-red-600">⚠️ Urgent notification</p>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                            <input type="radio" name="reminder_type" value="manual" required class="w-4 h-4 text-blue-600">
                            <div class="ml-3">
                                <span class="font-medium text-gray-900">Custom Manual Reminder</span>
                                <p class="text-xs text-gray-600">General notification</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeBulkReminderModal()"
                            class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-200">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-800 shadow-lg transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Send Bulk Reminders
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Single permit reminder modal
    function openReminderModal(permitId, permitName) {
        const modal = document.getElementById('reminderModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.getElementById('permitName').textContent = permitName;
        document.getElementById('reminderForm').action = `/permits/${permitId}/send-reminder`;
    }

    function closeReminderModal() {
        const modal = document.getElementById('reminderModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.getElementById('reminderForm').reset();
    }

    // Bulk reminder modal
    function openBulkReminderModal(permitIds) {
        if (permitIds.length === 0) {
            alert('Please select at least one permit');
            return;
        }

        // Get permit details from checkboxes
        const permits = permitIds.map(id => {
            const checkbox = document.querySelector(`input[type="checkbox"][value="${id}"]`);
            return checkbox ? checkbox.closest('.bg-white').querySelector('h3').textContent.trim() : '';
        }).filter(Boolean);

        document.getElementById('bulkSelectedCount').textContent = `${permitIds.length} permit${permitIds.length > 1 ? 's' : ''}`;
        document.getElementById('bulkPermitIds').value = JSON.stringify(permitIds);

        const permitsList = permits.map(name => `• ${name}`).join('<br>');
        document.getElementById('bulkPermitsList').innerHTML = permitsList;

        const bulkModal = document.getElementById('bulkReminderModal');
        bulkModal.classList.remove('hidden');
        bulkModal.classList.add('flex');
    }

    function closeBulkReminderModal() {
        const bulkModal = document.getElementById('bulkReminderModal');
        bulkModal.classList.add('hidden');
        bulkModal.classList.remove('flex');
        document.getElementById('bulkReminderForm').reset();
    }

    // Bulk delete
    function bulkDelete(permitIds) {
        if (permitIds.length === 0) {
            alert('Please select at least one permit to delete');
            return;
        }

        if (!confirm(`Are you sure you want to delete ${permitIds.length} permit${permitIds.length > 1 ? 's' : ''}? This action cannot be undone.`)) {
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("permits.bulk-delete") }}';

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        const idsInput = document.createElement('input');
        idsInput.type = 'hidden';
        idsInput.name = 'permit_ids';
        idsInput.value = JSON.stringify(permitIds);
        form.appendChild(idsInput);

        document.body.appendChild(form);
        form.submit();
    }

    // Close modals when clicking outside
    document.getElementById('reminderModal').addEventListener('click', function(e) {
        if (e.target === this) closeReminderModal();
    });

    document.getElementById('bulkReminderModal').addEventListener('click', function(e) {
        if (e.target === this) closeBulkReminderModal();
    });

    // Close modals with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeReminderModal();
            closeBulkReminderModal();
        }
    });
</script>
@endsection
