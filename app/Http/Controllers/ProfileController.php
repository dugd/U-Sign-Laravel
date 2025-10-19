<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Services\FeatureGate;
use App\Services\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display a user's public profile.
     */
    public function show(string $user): View
    {
        // find by ID first, then by vanity_slug
        $profile = User::where('id', $user)
            ->orWhere('vanity_slug', $user)
            ->firstOrFail();

        $profile->load(['gestures' => function($query) {
            $query->where('visibility', 'public')
                ->with('translations')
                ->latest()
                ->limit(10);
        }, 'fingerspellingGesture.translations']);

        return view('profile.show', [
            'profile' => $profile,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $featureGate = new FeatureGate();
        $subscriptionService = new SubscriptionService();

        $userGestures = $user->gestures()->with('translations')->get();

        return view('profile.edit', [
            'user' => $user,
            'userGestures' => $userGestures,
            'canUseVanitySlug' => $featureGate->allow($user, 'profile.vanity_slug'),
            'canUseFingerspelling' => $featureGate->allow($user, 'profile.fingerspelling'),
            'currentPlan' => $subscriptionService->currentPlan($user),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $featureGate = new FeatureGate();
        $validated = $request->validated();

        $user->fill($request->only(['name', 'email']));

        if ($featureGate->allow($user, 'profile.vanity_slug') && isset($validated['vanity_slug'])) {
            $user->vanity_slug = $validated['vanity_slug'];
        }

        if ($featureGate->allow($user, 'profile.fingerspelling') && array_key_exists('fingerspelling_gesture_id', $validated)) {
            $user->fingerspelling_gesture_id = $validated['fingerspelling_gesture_id'];
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
