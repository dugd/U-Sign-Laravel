<x-site-layout>
    <x-site-container>
        <div class="space-y-8">
            {{-- Profile Header --}}
            <header class="space-y-4">
                <div class="flex items-start gap-4">
                    @if($profile->avatar)
                        <img src="{{ $profile->avatar }}" alt="{{ $profile->name }}" class="w-24 h-24 rounded-full object-cover">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                            <span class="text-3xl font-bold text-gray-600">{{ strtoupper(substr($profile->name, 0, 1)) }}</span>
                        </div>
                    @endif

                    <div class="flex-1">
                        <h1 class="text-3xl font-bold">{{ $profile->name }}</h1>
                        @if($profile->vanity_slug)
                            <p class="text-sm text-gray-500 mt-1">{{ $profile->vanity_slug }}</p>
                        @endif

                        <div class="mt-2 text-sm text-gray-600">
                            Member since {{ $profile->created_at?->format('F Y') }}
                        </div>
                    </div>
                </div>

                {{-- Fingerspelling Gesture --}}
                @if($profile->fingerspellingGesture)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-blue-900 mb-2">Fingerspelling Gesture</h3>
                        <a href="{{ route('gestures.show', $profile->fingerspellingGesture) }}" class="text-blue-600 hover:underline">
                            {{ $profile->fingerspellingGesture->translations->first()?->title ?? 'View gesture' }}
                        </a>
                    </div>
                @endif
            </header>

            {{-- Public Gestures --}}
            @if($profile->gestures->count() > 0)
                <section>
                    <h2 class="text-2xl font-bold mb-4">Public Gestures</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($profile->gestures as $gesture)
                            <a href="{{ route('gestures.show', $gesture) }}" class="block border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <h3 class="font-semibold text-lg">{{ $gesture->translations->first()?->title ?? 'Untitled' }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $gesture->created_at?->format('M d, Y') }}</p>
                                @if($gesture->translations->first()?->description)
                                    <p class="text-sm text-gray-700 mt-2 line-clamp-2">{{ Str::limit($gesture->translations->first()->description, 100) }}</p>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </section>
            @else
                <section class="text-center py-12 text-gray-500">
                    <p>No public gestures yet.</p>
                </section>
            @endif
        </div>
    </x-site-container>
</x-site-layout>
