<x-app-layout>
    <x-site-container>
        <header class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Gestures</h1>
                <p class="text-gray-600 mt-1">Browse, filter and discover sign gestures.</p>
                <div class="mt-2 text-sm text-gray-500">
                    {{ __('Used') }}: <span class="font-semibold">{{ $used }}</span> / <span class="font-semibold">{{ $limit ? $limit : "∞" }}</span>
                </div>
            </div>
            <a href="{{ route('gestures.create') }}" class="btn btn-primary px-4 py-2 rounded text-white bg-blue-600 hover:bg-blue-700">+ {{ __('Add Gesture') }}</a>
        </header>

        {{-- Filters --}}
        <section>
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Filters') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Refine your search by language, keyword or available video.') }}
                </p>
            </header>

            <form method="GET" class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Language --}}
                <div class="md:col-span-2">
                    <x-select
                        id="lang"
                        name="lang"
                        label="Language"
                        :value="$lang"
                        :options="$languages->mapWithKeys(fn($c) => [$c => strtoupper($c)])"
                        placeholder="All languages"
                    />
                </div>

                {{-- Search --}}
                <div class="md:col-span-2">
                    <x-input-label for="q" :value="__('Search')" />
                    <x-text-input
                        id="q"
                        name="q"
                        type="text"
                        class="mt-1 block w-full"
                        :value="$q"
                        placeholder="{{ __('Search by title or description') }}"
                    />
                </div>

                {{-- With video --}}
                <div class="flex items-end">
                    <x-checkbox
                        id="has_video"
                        name="has_video"
                        :checked="$hasVideo"
                        :label="__('With video only')"
                    />
                </div>

                {{-- Buttons --}}
                <div class="md:col-span-4 flex items-center gap-3 mt-2">
                    <x-primary-button>{{ __('Apply filters') }}</x-primary-button>
                    <a href="{{ route('gestures.index') }}" class="text-sm text-gray-600 underline hover:no-underline">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>
        </section>

        {{-- Cards --}}
        @if($gestures->count())
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($gestures as $gesture)
                    @php
                        $preferredTranslation =
                            ($lang ? $gesture->translations->firstWhere('language_code', $lang) : null)
                            ?? $gesture->translations->firstWhere('language_code', $gesture->canonical_language_code)
                            ?? $gesture->translations->first();

                        $title = $preferredTranslation?->title ?? 'Untitled gesture';
                        $language = $preferredTranslation?->language_code ?? ($lang ?: $gesture->canonical_language_code ?? 'n/a');
                        $videoPath = $preferredTranslation?->video_path ?? null;
                        $videoUrl = $videoPath ? \Illuminate\Support\Facades\Storage::disk('public')->url($videoPath) : null;
                    @endphp

                    <article class="rounded-2xl border border-gray-200 overflow-hidden bg-white flex flex-col">
                        @if($videoUrl)
                            <a href="{{ route('gestures.show', $gesture) }}" class="block">
                                <video src="{{ $videoUrl }}" muted loop playsinline preload="metadata"
                                       class="w-full aspect-video object-cover bg-black"></video>
                            </a>
                        @else
                            <a href="{{ route('gestures.show', $gesture) }}" class="block">
                                <div class="w-full aspect-video bg-gray-100 flex items-center justify-center text-gray-400">
                                    No video
                                </div>
                            </a>
                        @endif

                        <div class="p-4 space-y-2 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between">
                                    <h3 class="font-semibold line-clamp-1">
                                        <a class="hover:underline" href="{{ route('gestures.show', $gesture) }}">
                                            {{ $title }}
                                        </a>
                                    </h3>
                                    <span class="text-xs px-2 py-0.5 rounded bg-gray-100">{{ strtoupper($language) }}</span>
                                </div>

                                @if($preferredTranslation?->description)
                                    <p class="text-sm text-gray-600 line-clamp-2">
                                        {{ $preferredTranslation->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex items-center justify-between text-xs text-gray-500 pt-1">
                                <span>By {{ $gesture->author?->name ?? 'Unknown' }}</span>
                                <span>{{ $gesture->created_at?->format('Y-m-d') }}</span>
                            </div>

                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('gestures.edit', $gesture) }}" class="btn btn-sm btn-warning">{{ __('Edit') }}</a>
                                <form action="{{ route('gestures.destroy', $gesture) }}" method="POST" onsubmit="return confirm('Delete gesture?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                </form>
                                    <a href="{{ route('gestures.show', $gesture) }}" class="btn btn-sm btn-info">{{ __('View') }}</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $gestures->onEachSide(1)->links() }}
            </div>
        @else
            <div class="mt-8 rounded-xl border border-dashed border-gray-300 p-8 text-center text-gray-600">
                {{ __('No gestures found. Try changing filters.') }}
            </div>
        @endif

        <x-site-session-status :status="session('status')"/>
    </x-site-container>
</x-site-layout>
