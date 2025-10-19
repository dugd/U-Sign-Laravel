<?php

namespace App\Http\Controllers;

use App\Http\Requests\SwitchSubscriptionRequest;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    protected SubscriptionService $subscriptionService;

    public function __construct()
    {
        $this->subscriptionService = new SubscriptionService();
    }

    /**
     * Display subscription management page.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $currentSubscription = $this->subscriptionService->current($user);
        $currentPlan = $this->subscriptionService->currentPlan($user);

        // TODO: move to database
        $plans = [
            'free' => [
                'name' => 'Free',
                'price' => 0,
                'features' => [
                    'Up to 10 gestures',
                    'Public gestures only',
                    'Community comments',
                ],
            ],
            'vip' => [
                'name' => 'VIP',
                'price' => 9.99,
                'features' => [
                    'Up to 50 gestures',
                    'Custom profile URL',
                    'Public gestures only',
                    'Priority support',
                ],
            ],
            'pro' => [
                'name' => 'Pro',
                'price' => 19.99,
                'features' => [
                    'Unlimited gestures',
                    'Custom profile URL',
                    'Private gestures',
                    'Fingerspelling showcase',
                    'Priority support',
                ],
            ],
        ];

        return view('subscription.index', [
            'currentPlan' => $currentPlan,
            'currentSubscription' => $currentSubscription,
            'plans' => $plans,
        ]);
    }

    /**
     * Switch to a different subscription plan.
     */
    public function switch(SwitchSubscriptionRequest $request): RedirectResponse
    {
        $user = $request->user();
        $newPlan = $request->validated()['plan'];
        $currentPlan = $this->subscriptionService->currentPlan($user);

        // No same plan
        if ($newPlan === $currentPlan) {
            return redirect()->route('subscription.index')
                ->with('error', 'You are already on the ' . ucfirst($newPlan) . ' plan.');
        }

        // Same as cancel
        if ($newPlan === 'free') {
            $this->subscriptionService->cancel($user);
            return redirect()->route('subscription.index')
                ->with('status', 'Your subscription has been canceled. You are now on the Free plan.');
        }

        // Switch to new
        $this->subscriptionService->switch($user, $newPlan);

        return redirect()->route('subscription.index')
            ->with('status', 'Successfully switched to ' . ucfirst($newPlan) . ' plan!');
    }

    /**
     * Cancel the current subscription.
     */
    public function cancel(Request $request): RedirectResponse
    {
        $user = $request->user();
        $currentPlan = $this->subscriptionService->currentPlan($user);

        if ($currentPlan === 'free') {
            return redirect()->route('subscription.index')
                ->with('error', 'You do not have an active subscription to cancel.');
        }

        $this->subscriptionService->cancel($user);

        return redirect()->route('subscription.index')
            ->with('status', 'Your subscription has been canceled successfully. You will retain access until the end of your billing period.');
    }

    /**
     * Display subscription history.
     */
    public function history(Request $request): View
    {
        $user = $request->user();
        $subscriptions = $this->subscriptionService->history($user);

        return view('subscription.history', [
            'subscriptions' => $subscriptions,
        ]);
    }
}
