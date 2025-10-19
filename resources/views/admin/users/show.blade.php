<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}: {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- User Information -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">User Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Role</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role->value === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($user->role->value) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Vanity Slug</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->vanity_slug ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email Verified</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($user->email_verified_at)
                                    <span class="text-green-600">✓ {{ $user->email_verified_at->format('Y-m-d H:i') }}</span>
                                @else
                                    <span class="text-red-600">Not verified</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Joined</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('Y-m-d H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Subscription Information -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Subscription Information</h3>

                    @if($activeSubscription)
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <h4 class="font-medium text-green-900 mb-2">Active Subscription</h4>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-green-700">Plan</dt>
                                    <dd class="mt-1 text-sm text-green-900">{{ strtoupper($activeSubscription->plan) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-green-700">Started</dt>
                                    <dd class="mt-1 text-sm text-green-900">{{ $activeSubscription->starts_at->format('Y-m-d') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-green-700">Ends</dt>
                                    <dd class="mt-1 text-sm text-green-900">{{ $activeSubscription->ends_at?->format('Y-m-d') ?? 'Never' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-green-700">Status</dt>
                                    <dd class="mt-1 text-sm text-green-900">
                                        @if($activeSubscription->canceled_at)
                                            Canceled (ends {{ $activeSubscription->canceled_at->format('Y-m-d') }})
                                        @else
                                            Active
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    @else
                        <p class="text-gray-500 mb-4">No active subscription (Free plan)</p>
                    @endif

                    @if($subscriptionHistory->count())
                        <h4 class="font-medium text-gray-900 mb-3">Subscription History</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Plan</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Started</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ends</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($subscriptionHistory as $subscription)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ strtoupper($subscription->plan) }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $subscription->starts_at->format('Y-m-d') }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $subscription->ends_at?->format('Y-m-d') ?? 'Never' }}</td>
                                            <td class="px-4 py-2 text-sm">
                                                @if($subscription->canceled_at)
                                                    <span class="text-orange-600">Canceled</span>
                                                @elseif($subscription->ends_at && $subscription->ends_at->isPast())
                                                    <span class="text-red-600">Expired</span>
                                                @else
                                                    <span class="text-green-600">Active</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Gestures -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Gestures ({{ $user->gestures->count() }})
                    </h3>

                    @if($user->gestures->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Language</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Visibility</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($user->gestures as $gesture)
                                        <tr>
                                            <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $gesture->slug }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ strtoupper($gesture->canonical_language_code) }}</td>
                                            <td class="px-4 py-2 text-sm">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $gesture->visibility === 'public' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($gesture->visibility) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $gesture->created_at->format('Y-m-d') }}</td>
                                            <td class="px-4 py-2 text-sm text-right">
                                                <a href="{{ route('admin.gestures.show', $gesture) }}" class="text-blue-600 hover:text-blue-900">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No gestures created yet.</p>
                    @endif
                </div>
            </div>

            <!-- Comments -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Comments ({{ $user->comments->count() }})
                    </h3>

                    @if($user->comments->count())
                        <div class="space-y-4">
                            @foreach($user->comments as $comment)
                                <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="text-sm text-gray-500">On gesture:</span>
                                                <a href="{{ route('admin.gestures.show', $comment->gesture) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                                    {{ $comment->gesture?->slug ?? 'Unknown' }}
                                                </a>
                                            </div>
                                            <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-4 flex-shrink-0">{{ $comment->created_at->format('Y-m-d') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No comments posted yet.</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            @if($user->id !== auth()->id())
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Danger Zone</h3>
                        <div class="flex items-center justify-between p-4 border border-red-200 rounded-lg bg-red-50">
                            <div>
                                <h4 class="font-medium text-red-900">Delete User</h4>
                                <p class="text-sm text-red-700">This will permanently delete the user and all their gestures and comments.</p>
                            </div>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                    Delete User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
