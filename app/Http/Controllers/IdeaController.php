<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index()
    {
        return view('idea.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Idea $idea)
    {
        return view('idea.show', [
            'idea' => $idea,
            'votesCount' => $idea->votes()->count(),
        ]);
    }

    public function edit(Idea $idea)
    {
        //
    }

    public function update(Request $request, Idea $idea)
    {
        //
    }

    public function destroy(Idea $idea)
    {
        //
    }
}
