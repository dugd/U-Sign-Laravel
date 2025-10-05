<x-site-layout>
    <x-site-container>
        <div class="space-y-2">
        {{-- Title + language --}}
        <header class="space-y-2">
            <h1 class="text-3xl font-bold">
                {{ $translation?->title ?? 'Untitled gesture' }}
            </h1>
            <div class="text-sm text-gray-500">
                Language: <span class="font-medium">{{ $translation?->language_code ?? 'n/a' }}</span>
            </div>
        </header>

        {{-- Author and metadata --}}
        <section class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
            <div>
                Author: <span class="font-medium">{{ $gesture->author?->name ?? 'Unknown' }}</span>
            </div>
            <span aria-hidden="true">•</span>
            <div>
                Created: {{ $gesture->created_at?->format('Y-m-d H:i') }}
            </div>
            @can('update', $gesture)
                <span aria-hidden="true">•</span>
                <a href="{{ route('gestures.edit', $gesture) }}"
                   class="underline hover:no-underline">Edit</a>
            @endcan
        </section>

        {{-- Video --}}
        @if($videoUrl)
            <section>
                <video
                    src="{{ $videoUrl }}"
                    controls
                    preload="metadata"
                    class="w-full rounded-xl shadow"
                >
                    Your browser does not support the video tag.
                </video>
            </section>
        @endif

        {{-- Description --}}
        @if($translation?->description)
            <section class="prose max-w-none">
                {!! nl2br(e($translation->description)) !!}
            </section>
        @endif

        {{-- Available translations (if more 1) --}}
        @if($gesture->translations->count() > 1)
            <section class="text-sm text-gray-600">
                Available translations:
                @foreach($gesture->translations as $tr)
                    <span class="inline-flex items-center gap-1 mr-2">
                        <span class="px-2 py-0.5 rounded bg-gray-100">{{ $tr->language_code }}</span>
                        @if($tr->is($translation))
                            <span class="text-green-600">(current)</span>
                        @endif
                    </span>
                @endforeach
            </section>
        @endif

        {{-- Comments list (existing) --}}
        @if(isset($gesture->comments) && $gesture->comments->isNotEmpty())
            <section class="space-y-4">
                <h2 class="text-xl font-semibold">Comments</h2>
                <div class="space-y-3">
                    @foreach($gesture->comments as $comment)
                        <article class="p-3 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between mb-1">
                                <div class="text-sm text-gray-500">
                                    {{ $comment->user?->name ?? 'Anonymous' }}
                                    • {{ $comment->created_at?->diffForHumans() }}
                                </div>

                                @can('delete', $comment)
                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs text-red-600 hover:underline"
                                                onclick="return confirm('Delete this comment?')">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                            </div>
                            <div class="whitespace-pre-line">{{ $comment->body }}</div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Create comment form (only for auth users) --}}
        @auth
            <section class="mt-6">
                <header>
                    <h3 class="text-lg font-medium text-gray-900">Add a comment</h3>
                    <p class="mt-1 text-sm text-gray-600">Share your thoughts about this gesture.</p>
                </header>

                <form method="POST" action="{{ route('comments.store', $gesture) }}" class="mt-4 space-y-3">
                    @csrf

                    <div>
                        <x-input-label for="body" :value="__('Comment')" />
                        <textarea
                            id="body"
                            name="body"
                            rows="4"
                            required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="{{ __('Write your comment...') }}"
                        >{{ old('body') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('body')" />
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>Post comment</x-primary-button>
                    </div>
                </form>
            </section>
        @else
            <section class="mt-6 text-sm text-gray-600">
                <a class="underline hover:no-underline" href="{{ route('login') }}">Sign in</a> to post a comment.
            </section>
        @endauth

        {{-- Flash message --}}
        <x-site-session-status :status="session('status')"/>
        </div>
    </x-site-container>
</x-site-layout>
