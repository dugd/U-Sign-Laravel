<?php

namespace App\Http\Controllers;

use App\Models\Gesture;
use App\Models\GestureTranslation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GestureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
