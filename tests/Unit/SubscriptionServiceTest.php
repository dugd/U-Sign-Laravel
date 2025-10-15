<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class SubscriptionServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_without_subscription_has_free_plan()
    {
        $user = User::factory()->create();
        $service = new SubscriptionService();
        $plan = $service->currentPlan($user);
        $this->assertEquals('free', $plan);
    }

    public function test_user_with_active_vip_subscription_has_vip_plan()
    {
        $user = User::factory()->create();
        Subscription::factory()->create([
            'user_id' => $user->id,
            'plan' => 'vip',
            'starts_at' => Carbon::now()->subDay(),
            'ends_at' => Carbon::now()->addDay(),
            'canceled_at' => null,
        ]);
        $service = new SubscriptionService();
        $plan = $service->currentPlan($user);
        $this->assertEquals('vip', $plan);
    }

    public function test_user_with_expired_subscription_has_free_plan()
    {
        $user = User::factory()->create();
        Subscription::factory()->create([
            'user_id' => $user->id,
            'plan' => 'pro',
            'starts_at' => Carbon::now()->subDays(10),
            'ends_at' => Carbon::now()->subDays(5),
            'canceled_at' => null,
        ]);
        $service = new SubscriptionService();
        $plan = $service->currentPlan($user);
        $this->assertEquals('free', $plan);
    }

    public function test_cancel_subscription_sets_plan_to_free()
    {
        $user = User::factory()->create();
        $sub = Subscription::factory()->create([
            'user_id' => $user->id,
            'plan' => 'vip',
            'starts_at' => Carbon::now()->subDay(),
            'ends_at' => Carbon::now()->addDay(),
            'canceled_at' => null,
        ]);
        $service = new SubscriptionService();
        $service->cancel($user);
        $sub->refresh();
        $this->assertNotNull($sub->canceled_at);
        $plan = $service->currentPlan($user);
        $this->assertEquals('free', $plan);
    }

    public function test_activate_subscription_sets_plan()
    {
        $user = User::factory()->create();
        $service = new SubscriptionService();
        $service->activate($user, 'pro', Carbon::now()->subDay(), Carbon::now()->addDay());
        $plan = $service->currentPlan($user);
        $this->assertEquals('pro', $plan);
    }
}

