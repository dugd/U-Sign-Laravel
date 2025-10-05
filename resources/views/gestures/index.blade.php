<x-site-layout>
    <x-site-container>
        <section class="text-center mb-10">
            <h1 class="text-3xl font-bold mb-2">Словник жестової мови</h1>
        </section>

        <section>
            <h2 class="text-xl font-semibold mb-4">Перелік жестів:</h2>

            <div class="grid gap-6 md:grid-cols-3">
                @forelse($gestures as $gesture)
                    <a href="{{ route('gestures.show', $gesture->id) }}" class="block bg-white shadow rounded p-4 hover:shadow-md">
                        <video src="{{ Storage::url($gesture->video_path) }}" class="w-full rounded mb-2" controls></video>
                        <h3 class="text-xl font-medium">{{ $gesture->title }}</h3>
                        <p class="">{{ trim(mb_substr($gesture->description, 0, 100)) . "..." }}</p>
                        <p class="text-sm text-gray-500">{{ $gesture->language_code }}</p>
                    </a>
                @empty
                    <p class="text-gray-500">Нема :(</p>
                @endforelse
            </div>
        </section>
    </x-site-container>
</x-site-layout>
