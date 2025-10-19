<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Subscription History') }}
            </h2>
            <a href="{{ route('subscription.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                ← Back to Subscriptions
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                @if($subscriptions->count() > 0)
                    <!-- Desktop Table -->
                    <div class="hidden md:block">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Plan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Start Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        End Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Duration
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($subscriptions as $subscription)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ ucfirst($subscription->plan) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $subscription->starts_at->format('M d, Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $subscription->starts_at->format('g:i A') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($subscription->ends_at)
                                                <div class="text-sm text-gray-900">
                                                    {{ $subscription->ends_at->format('M d, Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $subscription->ends_at->format('g:i A') }}
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-500">No end date</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $now = now();
                                                $isActive = $subscription->starts_at <= $now &&
                                                           (!$subscription->ends_at || $subscription->ends_at > $now) &&
                                                           (!$subscription->canceled_at || $subscription->canceled_at > $now);
                                                $isCanceled = $subscription->canceled_at && $subscription->canceled_at <= $now;
                                                $isExpired = $subscription->ends_at && $subscription->ends_at <= $now;
                                            @endphp

                                            @if($isActive)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @elseif($isCanceled)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                    Canceled
                                                </span>
                                            @elseif($isExpired)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Expired
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Scheduled
                                                </span>
                                            @endif

                                            @if($subscription->canceled_at)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    Canceled {{ $subscription->canceled_at->format('M d, Y') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($subscription->ends_at)
                                                {{ $subscription->starts_at->diffInDays($subscription->ends_at) }} days
                                            @else
                                                Ongoing
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="md:hidden divide-y divide-gray-200">
                        @foreach($subscriptions as $subscription)
                            @php
                                $now = now();
                                $isActive = $subscription->starts_at <= $now &&
                                           (!$subscription->ends_at || $subscription->ends_at > $now) &&
                                           (!$subscription->canceled_at || $subscription->canceled_at > $now);
                                $isCanceled = $subscription->canceled_at && $subscription->canceled_at <= $now;
                                $isExpired = $subscription->ends_at && $subscription->ends_at <= $now;
                            @endphp

                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ ucfirst($subscription->plan) }}</h3>
                                    @if($isActive)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @elseif($isCanceled)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                            Canceled
                                        </span>
                                    @elseif($isExpired)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Expired
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Scheduled
                                        </span>
                                    @endif
                                </div>

                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Start Date:</dt>
                                        <dd class="text-gray-900 font-medium">{{ $subscription->starts_at->format('M d, Y') }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">End Date:</dt>
                                        <dd class="text-gray-900 font-medium">
                                            @if($subscription->ends_at)
                                                {{ $subscription->ends_at->format('M d, Y') }}
                                            @else
                                                No end date
                                            @endif
                                        </dd>
                                    </div>
                                    @if($subscription->canceled_at)
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Canceled:</dt>
                                            <dd class="text-gray-900 font-medium">{{ $subscription->canceled_at->format('M d, Y') }}</dd>
                                        </div>
                                    @endif
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Duration:</dt>
                                        <dd class="text-gray-900 font-medium">
                                            @if($subscription->ends_at)
                                                {{ $subscription->starts_at->diffInDays($subscription->ends_at) }} days
                                            @else
                                                Ongoing
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($subscriptions->hasPages())
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $subscriptions->links() }}
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No subscription history</h3>
                        <p class="mt-1 text-sm text-gray-500">You haven't had any paid subscriptions yet.</p>
                        <div class="mt-6">
                            <a href="{{ route('subscription.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                View Available Plans
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
