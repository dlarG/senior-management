<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class SeniorProgramController extends Controller
{
    public function index()
    {
        $programs = Program::whereIn('status', ['active', 'upcoming'])
            ->orderBy('start_date')
            ->paginate(10);

        return view('senior.programs.index', compact('programs'));
    }

    public function show(Program $program)
    {
        $discussions = $program->discussions()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('senior.programs.show', compact('program', 'discussions'));
    }
}