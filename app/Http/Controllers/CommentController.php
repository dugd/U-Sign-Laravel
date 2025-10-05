<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Gesture;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Gesture $gesture) {
        $this->authorize('create', Comment::class);

        $validated = $request->validate([
            'body' => ['required','string','min:1','max:2000'],
        ]);

        $comment = new Comment([
            'body'       => $validated['body'],
            'user_id'    => $request->user()->id,
            'gesture_id' => $gesture->id,
        ]);
        $comment->save();

        return redirect()
            ->route('gestures.show', $gesture)
            ->with('status', 'Comment added.');
    }

    public function destroy(Comment $comment) {
        $this->authorize('delete', $comment);

        $gesture = $comment->gesture;
        $comment->delete();

        return redirect()
            ->route('gestures.show', $gesture)
            ->with('status', 'Comment deleted.');
    }
}
