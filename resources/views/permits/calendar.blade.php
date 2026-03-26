@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Permit Calendar</h2>
        <p class="text-gray-600 mt-2">Visual timeline of all permit expiration dates</p>
    </div>

    <!-- Legend -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Color Legend</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex items-center">
                <div class="w-4 h-4 rounded bg-green-500 mr-2"></div>
                <span class="text-sm text-gray-700">Safe (6+ months)</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded bg-blue-500 mr-2"></div>
                <span class="text-sm text-gray-700">Upcoming (3-6 months)</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded bg-orange-500 mr-2"></div>
                <span class="text-sm text-gray-700">Warning (1-3 months)</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded bg-red-500 mr-2"></div>
                <span class="text-sm text-gray-700">Critical/Expired</span>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div id="calendar"></div>
    </div>

    <!-- Event Details Modal -->
    <div id="eventModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 items-center justify-center p-4 hidden">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900" id="modalTitle"></h3>
                    <button onclick="closeEventModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <div id="modalContent" class="space-y-4"></div>

                <div class="mt-6 flex gap-3">
                    <a id="editBtn" href="#"
                        class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Edit Permit
                    </a>
                    <button onclick="closeEventModal()"
                        class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-200">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <style>
        .fc {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .fc-toolbar-title {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            color: #1f2937;
        }

        .fc-button {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            text-transform: capitalize !important;
            font-weight: 600 !important;
        }

        .fc-button:hover {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
        }

        .fc-button-active {
            background-color: #1d4ed8 !important;
            border-color: #1d4ed8 !important;
        }

        .fc-daygrid-day-number {
            font-weight: 600;
            color: #374151;
        }

        .fc-event {
            border: none !important;
            padding: 2px 4px !important;
            font-weight: 600 !important;
            border-radius: 4px !important;
        }

        .fc-daygrid-event {
            white-space: normal !important;
        }

        .fc-col-header-cell {
            background-color: #f3f4f6;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            color: #6b7280;
        }

        .fc-day-today {
            background-color: #dbeafe !important;
        }
    </style>
@endpush

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            if (!calendarEl) {
                console.error('Calendar element not found');
                return;
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,listMonth'
                },
                height: 'auto',
                events: @json($events),
                eventClick: function (info) {
                    showEventDetails(info.event);
                },
                eventMouseEnter: function (info) {
                    info.el.style.cursor = 'pointer';
                }
            });

            calendar.render();
        });

        function showEventDetails(event) {
            const props = event.extendedProps;
            const daysLeft = props.days_until_expiry;

            let statusBadge = '';
            if (daysLeft < 0) {
                statusBadge = '<span class="px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800">Expired</span>';
            } else if (daysLeft <= 30) {
                statusBadge = '<span class="px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800">Critical</span>';
            } else if (daysLeft <= 90) {
                statusBadge = '<span class="px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">Warning</span>';
            } else if (daysLeft <= 180) {
                statusBadge = '<span class="px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">Upcoming</span>';
            } else {
                statusBadge = '<span class="px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">Safe</span>';
            }

            document.getElementById('modalTitle').textContent = event.title;
            document.getElementById('editBtn').href = `/permits/${event.id}/edit`;

            const content = `
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Status</span>
                        ${statusBadge}
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm font-medium text-gray-600 block mb-1">Permit Number</span>
                            <span class="text-base font-semibold text-gray-900">${props.permit_number || 'N/A'}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600 block mb-1">Days Until Expiry</span>
                            <span class="text-base font-semibold ${daysLeft < 0 ? 'text-red-600' : 'text-blue-600'}">
                                ${Math.abs(daysLeft)} days ${daysLeft < 0 ? 'overdue' : 'remaining'}
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <span class="text-sm font-medium text-gray-600 block mb-2">Boss Details</span>
                        <div class="space-y-1">
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">${props.boss_name}</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-gray-700">${props.boss_email}</span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-600 block mb-1">Issue Date</span>
                                <span class="text-base text-gray-900">${props.issue_date}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600 block mb-1">Expiry Date</span>
                                <span class="text-base font-semibold ${daysLeft < 0 ? 'text-red-600' : 'text-blue-600'}">${props.expiry_date}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('modalContent').innerHTML = content;
            const modal = document.getElementById('eventModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        const modal = document.getElementById('eventModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        function closeEventModal() {
            document.getElementById('eventModal').classList.add('hidden');
        }

        document.getElementById('eventModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeEventModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeEventModal();
            }
        });
    </script>
@endpush
