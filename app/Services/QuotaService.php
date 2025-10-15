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
            case 'admin':
                return null; // null means unlimited
            default:
                return 10;
        }
    }

    public function used(User $user): int
    {
        return Gesture::where('created_by', $user->id)->count();
    }

    public function canCreate(User $user): bool
    {
        $plan = $this->subscriptionService->currentPlan($user);
        $limit = $this->limitFor($plan);
        if ($limit === null) {
            return true;
        }
        return $this->used($user) < $limit;
    }
}
