<?php
// app/Http/Controllers/Admin/ProgramController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Discussion;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::withCount('discussions')->latest()->paginate(10);
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'allow_discussion' => 'sometimes|boolean'
        ]);

        $program = Program::create([
            ...$request->only('name', 'description', 'start_date', 'start_time', 'end_time'),
            'user_id' => auth()->id(),
            'allow_discussion' => $request->has('allow_discussion')
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Program created!');
    }

    public function show(Program $program)
    {
        $discussions = $program->discussions()->with('user')->latest()->paginate(10);
        return view('admin.programs.show', compact('program', 'discussions'));
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            // same as store
        ]);

        $program->update([
            ...$request->except('allow_discussion'),
            'allow_discussion' => $request->has('allow_discussion')
        ]);

        return redirect()->route('admin.programs.show', $program)->with('success', 'Program updated!');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program deleted!');
    }
    public function markSuccessful(Program $program)
    {
        // Check if program has ended
        if ($program->hasEnded()) {
            $program->update(['status' => 'successful']);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
}