<?php

namespace App\Policies;

use App\Models\Gesture;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GesturePolicy
{
    public function viewAny(?User $user): bool { return true; }
    public function view(?User $user, Gesture $gesture): bool { return true; }

    public function create(User $user): bool { return $user !== null; }

    public function update(User $user, Gesture $gesture): bool {
        return $user->isAdmin() || $gesture->user_id === $user->id;
    }

    public function delete(User $user, Gesture $gesture): bool {
        return $user->isAdmin() || $gesture->user_id === $user->id;
    }
}
