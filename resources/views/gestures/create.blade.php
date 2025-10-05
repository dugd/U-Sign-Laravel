<x-site-layout>
    @section('title', 'Create Gesture')

    <x-site-container>
        <h1 class="text-2xl font-semibold mb-6">Create Gesture</h1>

        <form method="POST" action="{{ route('gestures.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Gesture core --}}
            <div>
                <x-input-label for="slug" :value="__('Slug')" />
                <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" value="{{ old('slug') }}" />
                <p class="mt-1 text-xs text-gray-500">Only letters, numbers, dashes and underscores.</p>
                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="canonical_language_code" :value="__('Canonical language code')" />
                <x-text-input id="canonical_language_code" name="canonical_language_code" type="text" class="mt-1 block w-full" value="{{ old('canonical_language_code') }}" placeholder="en, uk, etc." />
                <x-input-error :messages="$errors->get('canonical_language_code')" class="mt-2" />
            </div>

            {{-- Translation --}}
            <div class="border-t pt-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Translation</h2>

                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="translation_language_code" :value="__('Language code')" />
                        <x-text-input id="translation_language_code" name="translation[language_code]" type="text" class="mt-1 block w-full" value="{{ old('translation.language_code') }}" />
                        <x-input-error :messages="$errors->get('translation.language_code')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="translation_title" :value="__('Title')" />
                        <x-text-input id="translation_title" name="translation[title]" type="text" class="mt-1 block w-full" value="{{ old('translation.title') }}" />
                        <x-input-error :messages="$errors->get('translation.title')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="translation_description" :value="__('Description')" />
                    <textarea id="translation_description" name="translation[description]" rows="5" class="mt-1 block w-full rounded-md border-gray-300">{{ old('translation.description') }}</textarea>
                    <x-input-error :messages="$errors->get('translation.description')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="translation_video" :value="__('Video file (optional)')" />
                    <input id="translation_video" name="translation[video]" type="file" accept="video/mp4,video/webm,video/quicktime" class="mt-2 block w-full text-sm text-gray-700" />
                    <p class="mt-1 text-xs text-gray-500">MP4/WebM/MOV, up to 50 MB.</p>
                    <x-input-error :messages="$errors->get('translation.video')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>Save</x-primary-button>
                <a href="{{ route('gestures.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
            </div>
        </form>
    </x-site-container>
</x-site-layout>
