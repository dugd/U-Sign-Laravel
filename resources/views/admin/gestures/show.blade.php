<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gesture Details') }}: {{ $gesture->slug }}
            </h2>
            <a href="{{ route('admin.gestures.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Gestures
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Gesture Information -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Gesture Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Slug</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $gesture->slug }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Author</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="{{ route('admin.users.show', $gesture->author) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $gesture->author?->name ?? 'Unknown' }}
                                </a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Canonical Language</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ strtoupper($gesture->canonical_language_code) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Visibility</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $gesture->visibility === 'public' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($gesture->visibility) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $gesture->created_at->format('Y-m-d H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $gesture->updated_at->format('Y-m-d H:i') }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Public URL</dt>
                            <dd class="mt-1 text-sm">
                                <a href="{{ route('gestures.show', $gesture) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                    {{ route('gestures.show', $gesture) }} ↗
                                </a>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Translations -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Translations ({{ $gesture->translations->count() }})
                    </h3>

                    @if($gesture->translations->count())
                        <div class="space-y-6">
                            @foreach($gesture->translations as $translation)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $translation->title }}</h4>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                                {{ strtoupper($translation->language_code) }}
                                                @if($translation->language_code === $gesture->canonical_language_code)
                                                    <span class="ml-1">(Canonical)</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    @if($translation->description)
                                        <div class="mb-3">
                                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $translation->description }}</dd>
                                        </div>
                                    @endif

                                    @if($translation->video_path)
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 mb-2">Video</dt>
                                            <video
                                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($translation->video_path) }}"
                                                controls
                                                class="w-full max-w-md rounded-lg border border-gray-200"
                                            ></video>
                                        </div>
                                    @else
                                        <div class="text-sm text-gray-500 italic">No video uploaded</div>
                                    @endif

                                    <div class="mt-3 text-xs text-gray-500">
                                        Created: {{ $translation->created_at->format('Y-m-d H:i') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No translations available.</p>
                    @endif
                </div>
            </div>

            <!-- Comments -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Comments ({{ $gesture->comments->count() }})
                    </h3>

                    @if($gesture->comments->count())
                        <div class="space-y-4">
                            @foreach($gesture->comments as $comment)
                                <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <a href="{{ route('admin.users.show', $comment->user) }}" class="font-medium text-blue-600 hover:text-blue-800">
                                                    {{ $comment->user?->name ?? 'Unknown' }}
                                                </a>
                                                <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No comments yet.</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Danger Zone</h3>
                    <div class="flex items-center justify-between p-4 border border-red-200 rounded-lg bg-red-50">
                        <div>
                            <h4 class="font-medium text-red-900">Delete Gesture</h4>
                            <p class="text-sm text-red-700">This will permanently delete the gesture, all its translations, and all comments.</p>
                        </div>
                        <form action="{{ route('admin.gestures.destroy', $gesture) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this gesture? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                Delete Gesture
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
