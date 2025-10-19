<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gesture;
use Illuminate\Http\Request;

class GestureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Gesture::query()
            ->with(['author', 'translations'])
            ->withCount('comments');

        // Search by slug or author
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('slug', 'like', "%{$search}%")
                  ->orWhereHas('author', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('translations', function($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  });
            });
        }

        if ($visibility = $request->get('visibility')) {
            $query->where('visibility', $visibility);
        }

        if ($lang = $request->get('lang')) {
            $query->whereHas('translations', function($q) use ($lang) {
                $q->where('language_code', $lang);
            });
        }

        if ($authorId = $request->get('author_id')) {
            $query->where('created_by', $authorId);
        }

        $gestures = $query->latest()->paginate(20);

        return view('admin.gestures.index', compact('gestures'));
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
    public function show(Gesture $gesture)
    {
        $gesture->load(['author', 'translations', 'comments.user']);

        return view('admin.gestures.show', compact('gesture'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gesture $gesture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gesture $gesture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gesture $gesture)
    {
        $gesture->delete();

        return redirect()->route('admin.gestures.index')
            ->with('status', 'Gesture deleted successfully.');
    }
}
