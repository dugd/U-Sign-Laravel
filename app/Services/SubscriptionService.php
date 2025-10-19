<?php

namespace App\Services;

use App\Models\User;
use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionService
{
    public function current(User $user): ?Subscription
    {
        return Subscription::forUser($user->id)
            ->active()
            ->latest('starts_at')
            ->first();
    }

    public function currentPlan(User $user): string
    {
        return optional($this->current($user))->plan ?? 'free';
    }

    public function activate(User $user, string $plan, Carbon $startsAt, ?Carbon $endsAt = null): Subscription
    {
        return Subscription::create([
            'user_id' => $user->id,
            'plan' => $plan,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'canceled_at'=> null,
        ]);
    }

    public function cancel(User $user): bool
    {
        $subscription = $this->current($user);
        if (!$subscription) {
            return false;
        }
        $subscription->canceled_at = Carbon::now();
        return $subscription->save();
    }

    public function switch(User $user, string $newPlan): Subscription
    {
        $current = $this->current($user);
        if ($current) {
            $current->canceled_at = Carbon::now();
            // $current->ends_at = Carbon::now();
            $current->save();
        }

        return $this->activate(
            $user,
            $newPlan,
            Carbon::now(),
            Carbon::now()->addMonth() // Monthly
        );
    }

    public function history(User $user)
    {
        return Subscription::forUser($user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }
}
