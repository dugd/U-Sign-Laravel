<?php

namespace App\Http\Controllers;

use App\Models\Gesture;
use App\Models\GestureTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GestureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        // TODO: Gestures list
        $gestures = Gesture::with('translations')->get();
        // Oh sheesh...
        $gestures = $gestures->map(function ($gesture) {
            return (object) [
                'id' => $gesture->id,
                'title' => $gesture->translations[0]->title,
                'description' => $gesture->translations[0]->description,
                'video_path' => $gesture->translations[0]->video_path,
                'language_code' => $gesture->translations[0]->language_code,
                ];
        });
        return view('gestures.index', ['gestures' => $gestures]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Gesture::class);

        return view('gestures.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Gesture::class);

        DB::transaction(function () use ($request) {
            $gesture = Gesture::create([
                'slug' => $request->string('slug'),
                'canonical_language_code' => $request->string('canonical_language_code'),
                'created_by' => $request->user()->id,
            ]);

            $videoPath = null;
            if ($request->hasFile('translation.video')) {
                $videoPath = $request->file('translation.video')->storePublicly(
                    'videos/gestures',
                    ['disk' => 'public']
                );
            }

            $gesture->translations()->create([
                'language_code' => $request->input('translation.language_code'),
                'title' => $request->input('translation.title'),
                'description' => $request->input('translation.description'),
                'video_path' => $videoPath,
            ]);
        });

        return redirect()->route('gestures.index')->with('status', 'Gesture created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gesture $gesture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gesture $gesture)
    {
        $this->authorize('update', $gesture);

        $translation = $gesture->translations()
            ->where('language_code', $gesture->canonical_language_code)
            ->first() ?? $gesture->translations()->first();

        return view('gestures.edit', compact('gesture','translation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gesture $gesture)
    {
        $this->authorize('update', $gesture);

        DB::transaction(function () use ($request, $gesture) {
            $gesture->update([
                'slug' => $request->string('slug'),
                'canonical_language_code' => $request->string('canonical_language_code'),
            ]);

            $translation = $gesture->translations()
                ->where('language_code', $gesture->canonical_language_code)
                ->first() ?? $gesture->translations()->first();

            if (!$translation) {
                $translation = new GestureTranslation(['gesture_id' => $gesture->id]);
            }

            if ($request->boolean('translation.delete_video') && $translation->video_path) {
                Storage::disk('public')->delete($translation->video_path);
                $translation->video_path = null;
            }

            if ($request->hasFile('translation.video')) {
                if ($translation->video_path) {
                    Storage::disk('public')->delete($translation->video_path);
                }
                $translation->video_path = $request->file('translation.video')->storePublicly(
                    'videos/gestures',
                    ['disk' => 'public']
                );
            }

            $translation->language_code = $request->input('translation.language_code');
            $translation->title = $request->input('translation.title');
            $translation->description = $request->input('translation.description');
            $translation->gesture()->associate($gesture);
            $translation->save();
        });

        return redirect()->route('gestures.show', $gesture)->with('status', 'Gesture updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gesture $gesture)
    {
        //
    }
}
