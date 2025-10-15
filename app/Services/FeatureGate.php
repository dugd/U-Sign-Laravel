<?php

namespace App\Services;

use App\Models\User;
use App\Enums\UserRole;

class FeatureGate
{
    /**
     * Check if the user has access to the feature.
     */
    public function allow(User $user, string $key): bool
    {
        if ($user->role === UserRole::Admin) {
            return true;
        }

        $plan = $user->plan ?? 'free';
        switch ($key) {
            case 'profile.vanity_slug':
                return in_array($plan, ['vip', 'pro']);
            case 'profile.fingerspelling':
                return in_array($plan, ['pro']);
            case 'gesture.private':
                return in_array($plan, ['pro']);
            default:
                return false;
        }
    }
}

