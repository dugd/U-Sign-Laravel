<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Gesture;
use App\Models\Comment;
use App\Models\Subscription;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $stats = [
            'total_users' => User::count(),
            'total_gestures' => Gesture::count(),
            'total_comments' => Comment::count(),
            'active_subscriptions' => Subscription::active()->count(),
            'vip_subscriptions' => Subscription::active()->where('plan', 'vip')->count(),
            'pro_subscriptions' => Subscription::active()->where('plan', 'pro')->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentGestures = Gesture::with('author')->latest()->take(5)->get();
        $recentComments = Comment::with(['user', 'gesture'])->latest()->take(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recentUsers', 'recentGestures', 'recentComments'));
    }
}
