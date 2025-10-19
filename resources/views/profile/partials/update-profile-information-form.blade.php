<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Vanity Slug Field (VIP/Pro) --}}
        <div>
            <x-input-label for="vanity_slug" :value="__('Vanity Slug')" />
            @if($canUseVanitySlug)
                <x-text-input
                    id="vanity_slug"
                    name="vanity_slug"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('vanity_slug', $user->vanity_slug)"
                    placeholder="your-custom-slug"
                    autocomplete="off" />
                <p class="mt-1 text-xs text-gray-500">Your custom profile URL: /profile/your-custom-slug</p>
                <x-input-error class="mt-2" :messages="$errors->get('vanity_slug')" />
            @else
                <x-text-input
                    id="vanity_slug"
                    type="text"
                    class="mt-1 block w-full bg-gray-100"
                    value="Available on VIP and Pro plans"
                    disabled />
                <p class="mt-1 text-xs text-gray-500">
                    Your current plan: <span class="font-semibold">{{ ucfirst($currentPlan) }}</span>.
                    Upgrade to VIP or Pro to use custom profile URLs.
                </p>
            @endif
        </div>

        {{-- Fingerspelling Gesture Field (Pro only) --}}
        <div>
            <x-input-label for="fingerspelling_gesture_id" :value="__('Fingerspelling Gesture')" />
            @if($canUseFingerspelling)
                <select
                    id="fingerspelling_gesture_id"
                    name="fingerspelling_gesture_id"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">None</option>
                    @foreach($userGestures as $gesture)
                        <option
                            value="{{ $gesture->id }}"
                            @selected(old('fingerspelling_gesture_id', $user->fingerspelling_gesture_id) == $gesture->id)>
                            {{ $gesture->translations->first()?->title ?? 'Untitled Gesture' }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500">Select a gesture to display as your personal fingerspelling gesture on your profile.</p>
                <x-input-error class="mt-2" :messages="$errors->get('fingerspelling_gesture_id')" />
            @else
                <select
                    class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm"
                    disabled>
                    <option>Available on Pro plan</option>
                </select>
                <p class="mt-1 text-xs text-gray-500">
                    Your current plan: <span class="font-semibold">{{ ucfirst($currentPlan) }}</span>.
                    Upgrade to Pro to showcase your fingerspelling gesture.
                </p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
