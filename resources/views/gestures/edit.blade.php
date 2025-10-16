<x-site-layout>
    @section('title', 'Edit Gesture')
    <x-site-container>
        <h1 class="text-2xl font-semibold mb-6">Edit Gesture</h1>

        {{-- used/limit --}}
        @php
            $user = \Illuminate\Support\Facades\Auth::user();
            $quotaService = app(\App\Services\QuotaService::class);
            $featureGate = app(\App\Services\FeatureGate::class);
            $used = $quotaService->used($user);
            $limit = $quotaService->limitForUser($user);
            $canCreate = $quotaService->canCreate($user);
        @endphp
        <div class="mb-4 text-sm text-gray-700">
            Gestures used: <span class="font-bold">{{ $used }}</span>
            @if($limit !== null)
                / <span class="font-bold">{{ $limit }}</span>
            @else
                / <span class="font-bold">∞</span>
            @endif
        </div>

        <form method="POST" action="{{ route('gestures.update', $gesture) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Gesture core --}}
            <div>
                <x-input-label for="slug" :value="__('Slug')" />
                <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" value="{{ old('slug', $gesture->slug) }}" />
                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="canonical_language_code" :value="__('Canonical language code')" />
                <x-text-input id="canonical_language_code" name="canonical_language_code" type="text" class="mt-1 block w-full" value="{{ old('canonical_language_code', $gesture->canonical_language_code) }}" />
                <x-input-error :messages="$errors->get('canonical_language_code')" class="mt-2" />
            </div>

            <div>
                <x-select
                        id="visibility"
                        name="visibility"
                        label="Visibility"
                        :value="old('visibility', $gesture->visibility)"
                        :options="$featureGate->allow($user, 'gesture.private') ? ['public', 'private'] : ['public']"
                    />
                <x-input-error :messages="$errors->get('visibility')" class="mt-2" />
            </div>

            {{-- Translation --}}
            <div class="border-t pt-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Translation</h2>

                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="translation_language_code" :value="__('Language code')" />
                        <x-text-input id="translation_language_code" name="translation[language_code]" type="text" class="mt-1 block w-full" value="{{ old('translation.language_code', optional($translation)->language_code) }}" />
                        <x-input-error :messages="$errors->get('translation.language_code')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="translation_title" :value="__('Title')" />
                        <x-text-input id="translation_title" name="translation[title]" type="text" class="mt-1 block w-full" value="{{ old('translation.title', optional($translation)->title) }}" />
                        <x-input-error :messages="$errors->get('translation.title')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="translation_description" :value="__('Description')" />
                    <textarea id="translation_description" name="translation[description]" rows="5" class="mt-1 block w-full rounded-md border-gray-300">{{ old('translation.description', optional($translation)->description) }}</textarea>
                    <x-input-error :messages="$errors->get('translation.description')" class="mt-2" />
                </div>

                {{-- Existing video preview / delete / replace --}}
                @if($translation && $translation->video_path)
                    <div class="space-y-2">
                        <x-input-label :value="__('Current video')" />
                        <video class="w-full max-w-lg rounded" controls src="{{ Storage::url($translation->video_path) }}"></video>

                        <label class="inline-flex items-center gap-2 mt-2">
                            <input type="checkbox" name="translation[delete_video]" value="1" class="rounded border-gray-300">
                            <span class="text-sm text-gray-700">Delete current video</span>
                        </label>
                    </div>
                @endif

                <div>
                    <x-input-label for="translation_video" :value="__('Video file (optional)')" />
                    <input id="translation_video" name="translation[video]" type="file" accept="video/mp4,video/webm,video/quicktime" class="mt-2 block w-full text-sm text-gray-700" />
                    <x-input-error :messages="$errors->get('translation.video')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button type="submit" :disabled="!$canCreate">
                    Update Gesture
                </x-primary-button>
                @if(!$canCreate)
                    <span class="ml-2 text-red-500 text-sm">Gesture limit reached for your plan.</span>
                @endif
                <a href="{{ route('gestures.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
            </div>
        </form>
    </x-site-container>
</x-site-layout>
