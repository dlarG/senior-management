<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Program;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function store(Request $request, Program $program)
    {
        abort_unless($program->allow_discussion, 403, 'This program does not allow discussions');
        
        $request->validate(['content' => 'required|string|max:1000']);

        Discussion::create([
            'program_id' => $program->id,
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);

        return back()->with('success', 'Your comment has been posted');
    }
}