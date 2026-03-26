@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
        <p class="text-gray-600 mt-2">Overview of your permit monitoring system</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Permits -->
        <div
            class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Permits</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalPermits }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Permits -->
        <div
            class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active Permits</p>
                    <p class="text-4xl font-bold mt-2">{{ $activePermits }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Expired Permits -->
        <div
            class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Expired Permits</p>
                    <p class="text-4xl font-bold mt-2">{{ $expiredPermits }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Renewed Permits -->
        <div
            class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Renewed Permits</p>
                    <p class="text-4xl font-bold mt-2">{{ $renewedPermits }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Expiry Timeline Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Expiring 1 Month</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $expiringIn1Month }}</p>
                </div>
                <span class="text-4xl">⏰</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Expiring 3 Months</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $expiringIn3Months }}</p>
                </div>
                <span class="text-4xl">📅</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Expiring 6 Months</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $expiringIn6Months }}</p>
                </div>
                <span class="text-4xl">📊</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Upcoming Expiring Permits -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4">
                <h3 class="text-xl font-bold text-white">⚠️ Upcoming Expiring Permits</h3>
            </div>
            <div class="p-6">
                @if($upcomingExpiring->isEmpty())
                    <p class="text-gray-500 text-center py-8">No upcoming expiring permits</p>
                @else
                    <div class="space-y-4">
                        @foreach($upcomingExpiring as $permit)
                            @php
                                $daysLeft = $permit->daysUntilExpiry();
                                $urgencyColor = $daysLeft <= 30 ? 'red' : ($daysLeft <= 90 ? 'yellow' : 'blue');
                            @endphp
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $permit->permit_name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $permit->permit_number }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Expires: {{ $permit->expiry_date->format('d M Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-{{ $urgencyColor }}-100 text-{{ $urgencyColor }}-800">
                                        {{ $daysLeft }} days
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('permits.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                            View all permits →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Reminders -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-indigo-500 px-6 py-4">
                <h3 class="text-xl font-bold text-white">📧 Recent Reminders Sent</h3>
            </div>
            <div class="p-6">
                @if($recentReminders->isEmpty())
                    <p class="text-gray-500 text-center py-8">No reminders sent yet</p>
                @else
                    <div class="space-y-4">
                        @foreach($recentReminders as $reminder)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $reminder->permit->permit_name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $reminder->sent_to }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $reminder->created_at->diffForHumans() }}</p>
                                </div>
                                <div>
                                    @php
                                        $badgeClass = match ($reminder->reminder_type) {
                                            '1_month' => 'bg-red-100 text-red-800',
                                            '3_months' => 'bg-yellow-100 text-yellow-800',
                                            '6_months' => 'bg-blue-100 text-blue-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp

                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $badgeClass }}">
                                        {{ $reminder->getReminderTypeLabel() }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('permits.all-history') }}"
                            class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                            View all history →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="mt-8 bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">📊 Permits Status Distribution</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-6 bg-green-50 rounded-lg">
                <div class="text-4xl font-bold text-green-600">{{ $permitsByStatus['active'] }}</div>
                <div class="text-sm text-gray-600 mt-2">Active Permits</div>
                <div class="mt-2 bg-green-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full"
                        style="width: {{ $totalPermits > 0 ? ($permitsByStatus['active'] / $totalPermits * 100) : 0 }}%">
                    </div>
                </div>
            </div>

            <div class="text-center p-6 bg-red-50 rounded-lg">
                <div class="text-4xl font-bold text-red-600">{{ $permitsByStatus['expired'] }}</div>
                <div class="text-sm text-gray-600 mt-2">Expired Permits</div>
                <div class="mt-2 bg-red-200 rounded-full h-2">
                    <div class="bg-red-600 h-2 rounded-full"
                        style="width: {{ $totalPermits > 0 ? ($permitsByStatus['expired'] / $totalPermits * 100) : 0 }}%">
                    </div>
                </div>
            </div>

            <div class="text-center p-6 bg-purple-50 rounded-lg">
                <div class="text-4xl font-bold text-purple-600">{{ $permitsByStatus['renewed'] }}</div>
                <div class="text-sm text-gray-600 mt-2">Renewed Permits</div>
                <div class="mt-2 bg-purple-200 rounded-full h-2">
                    <div class="bg-purple-600 h-2 rounded-full"
                        style="width: {{ $totalPermits > 0 ? ($permitsByStatus['renewed'] / $totalPermits * 100) : 0 }}%">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-xl p-8 text-white text-center">
        <h3 class="text-2xl font-bold mb-4">Quick Actions</h3>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('permits.create') }}"
                class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Permit
            </a>
            <a href="{{ route('permits.index') }}"
                class="inline-flex items-center px-6 py-3 bg-white text-purple-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                View All Permits
            </a>
            <a href="{{ route('permits.all-history') }}"
                class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Reminder History
            </a>
        </div>
    </div>
@endsection
