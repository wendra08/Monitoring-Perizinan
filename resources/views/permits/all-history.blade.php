@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">All Reminder History</h2>
            <p class="text-gray-600 mt-2">Complete history of all reminder emails sent</p>
        </div>
    </div>

    @if($histories->isEmpty())
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <div class="max-w-md mx-auto">
                <div
                    class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No reminder history</h3>
                <p class="text-gray-600">No reminder emails have been sent yet.</p>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date &
                                Time</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permit
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reminder
                                Type</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent To
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($histories as $history)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $history->created_at->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $history->created_at->format('H:i:s') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $history->permit->permit_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $history->permit->permit_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        if ($history->reminder_type === '1_month') {
                                            $badgeClasses = 'bg-red-100 text-red-800';
                                        } elseif ($history->reminder_type === '3_months') {
                                            $badgeClasses = 'bg-yellow-100 text-yellow-800';
                                        } elseif ($history->reminder_type === '6_months') {
                                            $badgeClasses = 'bg-blue-100 text-blue-800';
                                        } else {
                                            $badgeClasses = 'bg-purple-100 text-purple-800';
                                        }
                                    @endphp

                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $badgeClasses }}">
                                        {{ $history->getReminderTypeLabel() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $history->sent_to }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($history->status)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Sent
                                        </span>
                                    @else
                                        <div class="group relative">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 cursor-help">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Failed
                                            </span>
                                            @if($history->error_message)
                                                <div
                                                    class="hidden group-hover:block absolute z-10 w-64 p-2 bg-gray-900 text-white text-xs rounded shadow-lg -top-2 left-full ml-2">
                                                    {{ $history->error_message }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('permits.history', $history->permit) }}"
                                            class="text-blue-600 hover:text-blue-900 font-medium">
                                            View
                                        </a>
                                        <form action="{{ route('reminder-history.destroy', $history) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this history record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $histories->links() }}
            </div>
        </div>
    @endif
@endsection
