<?php

namespace App\Services;

use App\Models\User;
use App\Models\Gesture;

class QuotaService
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function limitFor(string $plan): ?int
    {
        switch (strtolower($plan)) {
            case 'free':
                return 10;
            case 'vip':
                return 50;
            case 'pro':
                return null;
            default:
                return 10;
        }
    }

    public function limitForUser(User $user): ?int
    {
        if ($user->isAdmin()) {
            return null;
        }
        $plan = $this->subscriptionService->currentPlan($user);
        return $this->limitFor($plan);
    }

    public function used(User $user): int
    {
        return Gesture::where('created_by', $user->id)->count();
    }

    public function canCreate(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        $limit = $this->limitForUser($user);
        if ($limit === null) {
            return true;
        }
        return $this->used($user) < $limit;
    }
}
