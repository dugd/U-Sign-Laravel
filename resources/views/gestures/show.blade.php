<x-site-layout>
    <x-site-container>
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

        {{-- Comments (if exists) --}}
        @if(isset($gesture->comments) && $gesture->comments->isNotEmpty())
            <section class="space-y-4">
                <h2 class="text-xl font-semibold">Comments</h2>
                <div class="space-y-3">
                    @foreach($gesture->comments as $comment)
                        <article class="p-3 rounded-lg border border-gray-200">
                            <div class="text-sm text-gray-500 mb-1">
                                {{ $comment->user?->name ?? 'Anonymous' }}
                                • {{ $comment->created_at?->diffForHumans() }}
                            </div>
                            <div>{{ $comment->body }}</div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Flash message --}}
        <x-site-session-status :status="session('status')"/>
    </x-site-container>
</x-site-layout>
