<?php

namespace App\Http\Controllers\My;

use App\Http\Controllers\Controller;
use App\Models\Gesture;
use App\Models\GestureTranslation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GestureController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $lang = (string) $request->query('lang', '');
        $q = (string) $request->query('q', '');
        $hasVideo = $request->boolean('has_video', false);

        $query = Gesture::query()
            ->where('created_by', $user->id)
            ->with(['translations' => function ($t) use ($lang) {
                if ($lang) {
                    $t->where('language_code', $lang);
                }
            }]);

        if ($q !== '') {
            $query->whereHas('translations', function ($t) use ($q) {
                $t->where(function ($w) use ($q) {
                    $w->where('title', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
                });
            });
        }

        if ($hasVideo) {
            $query->whereHas('translations', function ($t) {
                $t->whereNotNull('video_path');
            });
        }

        $gestures = $query->latest('id')->paginate(12)->withQueryString();

        $quotaService = app(\App\Services\QuotaService::class);
        $used = $quotaService->used($user);
        $limit = $quotaService->limitForUser($user);

        $languages = GestureTranslation::query()
            ->select('language_code')
            ->distinct()
            ->orderBy('language_code')
            ->pluck('language_code');

        return view('my.gestures.index', [
            'gestures' => $gestures,
            'used' => $used,
            'languages' => $languages,
            'limit' => $limit,
            'lang' => $lang,
            'q' => $q,
            'hasVideo' => $hasVideo,
        ]);
    }
}
