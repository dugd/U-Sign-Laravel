<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div class="text-sm font-medium text-gray-500">Total Users</div>
                                <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Gestures -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div class="text-sm font-medium text-gray-500">Total Gestures</div>
                                <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_gestures']) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Comments -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div class="text-sm font-medium text-gray-500">Total Comments</div>
                                <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_comments']) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Subscriptions -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div class="text-sm font-medium text-gray-500">Active Subscriptions</div>
                                <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['active_subscriptions']) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VIP Subscriptions -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div class="text-sm font-medium text-gray-500">VIP Subscriptions</div>
                                <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['vip_subscriptions']) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pro Subscriptions -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-pink-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div class="text-sm font-medium text-gray-500">Pro Subscriptions</div>
                                <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['pro_subscriptions']) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Users -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Users</h3>
                        <div class="space-y-3">
                            @forelse($recentUsers as $user)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                    <div>
                                        <a href="{{ route('admin.users.show', $user) }}" class="font-medium text-gray-900 hover:text-blue-600">{{ $user->name }}</a>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($user->role->value) }}
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">No users yet.</p>
                            @endforelse
                        </div>
                        @if($recentUsers->count())
                            <div class="mt-4">
                                <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View all users →</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Gestures -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Gestures</h3>
                        <div class="space-y-3">
                            @forelse($recentGestures as $gesture)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('admin.gestures.show', $gesture) }}" class="font-medium text-gray-900 hover:text-blue-600 truncate block">
                                            {{ $gesture->slug }}
                                        </a>
                                        <p class="text-sm text-gray-500">by {{ $gesture->author?->name ?? 'Unknown' }}</p>
                                    </div>
                                    <div class="text-right ml-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $gesture->visibility === 'public' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($gesture->visibility) }}
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">{{ $gesture->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">No gestures yet.</p>
                            @endforelse
                        </div>
                        @if($recentGestures->count())
                            <div class="mt-4">
                                <a href="{{ route('admin.gestures.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View all gestures →</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Comments -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Comments</h3>
                    <div class="space-y-4">
                        @forelse($recentComments as $comment)
                            <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium text-gray-900">{{ $comment->user?->name ?? 'Unknown' }}</span>
                                            <span class="text-gray-500 text-sm">on</span>
                                            <a href="{{ route('admin.gestures.show', $comment->gesture) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                                {{ $comment->gesture?->slug ?? 'Unknown gesture' }}
                                            </a>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600">{{ Str::limit($comment->content, 150) }}</p>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-4 flex-shrink-0">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No comments yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            @if(session('status'))
                <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
