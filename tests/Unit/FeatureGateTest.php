<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\FeatureGate;
use App\Models\User;
use App\Enums\UserRole;

class FeatureGateTest extends TestCase
{
    protected FeatureGate $gate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gate = new FeatureGate();
    }

    private function makeUser($role, $plan = null)
    {
        $user = new User();
        $user->role = $role;
        $user->plan = $plan;
        return $user;
    }

    public function test_admin_has_all_features()
    {
        $user = $this->makeUser(UserRole::Admin);
        $this->assertTrue($this->gate->allow($user, 'profile.vanity_slug'));
        $this->assertTrue($this->gate->allow($user, 'profile.fingerspelling'));
        $this->assertTrue($this->gate->allow($user, 'gesture.private'));
        $this->assertTrue($this->gate->allow($user, 'unknown.key'));
    }

    public function test_vip_features()
    {
        $user = $this->makeUser(UserRole::User, 'vip');
        $this->assertTrue($this->gate->allow($user, 'profile.vanity_slug'));
        $this->assertFalse($this->gate->allow($user, 'profile.fingerspelling'));
        $this->assertFalse($this->gate->allow($user, 'gesture.private'));
    }

    public function test_pro_features()
    {
        $user = $this->makeUser(UserRole::User, 'pro');
        $this->assertTrue($this->gate->allow($user, 'profile.vanity_slug'));
        $this->assertTrue($this->gate->allow($user, 'profile.fingerspelling'));
        $this->assertTrue($this->gate->allow($user, 'gesture.private'));
    }

    public function test_free_features()
    {
        $user = $this->makeUser(UserRole::User, 'free');
        $this->assertFalse($this->gate->allow($user, 'profile.vanity_slug'));
        $this->assertFalse($this->gate->allow($user, 'profile.fingerspelling'));
        $this->assertFalse($this->gate->allow($user, 'gesture.private'));
    }

    public function test_unknown_plan()
    {
        $user = $this->makeUser(UserRole::User, 'unknown');
        $this->assertFalse($this->gate->allow($user, 'profile.vanity_slug'));
        $this->assertFalse($this->gate->allow($user, 'profile.fingerspelling'));
        $this->assertFalse($this->gate->allow($user, 'gesture.private'));
    }

    public function test_null_plan_defaults_to_free()
    {
        $user = $this->makeUser(UserRole::User, null);
        $this->assertFalse($this->gate->allow($user, 'profile.vanity_slug'));
        $this->assertFalse($this->gate->allow($user, 'profile.fingerspelling'));
        $this->assertFalse($this->gate->allow($user, 'gesture.private'));
    }
}

