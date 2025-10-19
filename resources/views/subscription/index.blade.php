<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subscription Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Status Messages -->
            @if (session('status'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Current Plan Section -->
            <div class="bg-white shadow sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Your Current Plan</h3>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-3xl font-bold text-indigo-600">{{ ucfirst($currentPlan) }}</p>
                            @if($currentSubscription && $currentSubscription->ends_at)
                                <p class="text-sm text-gray-600 mt-1">
                                    @if($currentSubscription->canceled_at)
                                        <span class="text-orange-600 font-medium">Canceled</span> - Access until {{ $currentSubscription->ends_at->format('M d, Y') }}
                                    @else
                                        Renews on {{ $currentSubscription->ends_at->format('M d, Y') }}
                                    @endif
                                </p>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('subscription.history') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                View History →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Plans -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($plans as $planKey => $plan)
                    <div class="bg-white shadow sm:rounded-lg overflow-hidden @if($planKey === $currentPlan) ring-2 ring-indigo-600 @endif">
                        <div class="p-6">
                            <!-- Plan Header -->
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-900">{{ $plan['name'] }}</h3>
                                @if($planKey === $currentPlan)
                                    <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded">Current</span>
                                @endif
                            </div>

                            <!-- Pricing -->
                            <div class="mb-6">
                                @if($plan['price'] > 0)
                                    <span class="text-4xl font-bold text-gray-900">${{ number_format($plan['price'], 2) }}</span>
                                    <span class="text-gray-600">/month</span>
                                @else
                                    <span class="text-4xl font-bold text-gray-900">Free</span>
                                @endif
                            </div>

                            <!-- Features List -->
                            <ul class="space-y-3 mb-6">
                                @foreach($plan['features'] as $feature)
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm text-gray-700">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- Action Button -->
                            @if($planKey !== $currentPlan)
                                <form method="POST" action="{{ route('subscription.switch') }}" class="w-full">
                                    @csrf
                                    <input type="hidden" name="plan" value="{{ $planKey }}">
                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-150">
                                        Switch to {{ $plan['name'] }}
                                    </button>
                                </form>
                            @else
                                @if($planKey !== 'free' && (!$currentSubscription || !$currentSubscription->canceled_at))
                                    <form method="POST" action="{{ route('subscription.cancel') }}"
                                          class="w-full"
                                          onsubmit="return confirm('Are you sure you want to cancel your subscription? You will retain access until the end of your billing period.')">
                                        @csrf
                                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-150">
                                            Cancel Subscription
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-gray-300 text-gray-500 font-semibold py-2 px-4 rounded-lg cursor-not-allowed">
                                        Current Plan
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Additional Information -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h4 class="font-semibold text-blue-900 mb-2">Important Information</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Plan changes take effect immediately</li>
                    <li>• When upgrading, you'll have immediate access to new features</li>
                    <li>• When downgrading, you'll retain access until the end of your current billing period</li>
                    <li>• Canceling a subscription will revert you to the Free plan at the end of the billing period</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
