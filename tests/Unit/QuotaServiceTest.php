<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Gesture;
use App\Services\QuotaService;
use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class QuotaServiceTest extends TestCase
{
    use RefreshDatabase;

    // preparation
    protected function createUserWithPlan(string $plan, int $gestures = 0)
    {
        $user = User::factory()->create();

        // Mock SubscriptionService
        $subscriptionService = Mockery::mock(SubscriptionService::class);
        $subscriptionService->shouldReceive('currentPlan')->andReturn($plan);
        $quotaService = new QuotaService($subscriptionService);

        if ($gestures > 0) {
            Gesture::factory()->count($gestures)->create(['created_by' => $user->id]);
        }
        return [$user, $quotaService];
    }

    public function testFreePlanLimit()
    {
        [$user, $quotaService] = $this->createUserWithPlan('free', 10);
        $this->assertEquals(10, $quotaService->used($user));
        $this->assertFalse($quotaService->canCreate($user));
    }

    public function testVipPlanLimit()
    {
        [$user, $quotaService] = $this->createUserWithPlan('vip', 50);
        $this->assertEquals(50, $quotaService->used($user));
        $this->assertFalse($quotaService->canCreate($user));
    }

    public function testProPlanUnlimited()
    {
        [$user, $quotaService] = $this->createUserWithPlan('pro', 100);
        $this->assertEquals(100, $quotaService->used($user));
        $this->assertTrue($quotaService->canCreate($user));
    }

    public function testAdminPlanUnlimited()
    {
        [$user, $quotaService] = $this->createUserWithPlan('admin', 100);
        $this->assertEquals(100, $quotaService->used($user));
        $this->assertTrue($quotaService->canCreate($user));
    }

    public function testCanCreateBelowLimit()
    {
        [$user, $quotaService] = $this->createUserWithPlan('free', 9);
        $this->assertTrue($quotaService->canCreate($user));
    }
}
