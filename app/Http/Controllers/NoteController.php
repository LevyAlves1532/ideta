<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idea_id)
    {
        $idea = Idea::where('id', $idea_id)->where('user_id', Auth::user()->id)->first();

        if ($idea) redirect()->route('ideas.index');

        return view('note.index', [
            'idea' => $idea,
        ]);
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
    public function store(Request $request, $idea_id)
    {
        $user_id = Auth::user()->id;
        $body = $request->only('body');

        $idea = Idea::where('id', $idea_id)->where('user_id', $user_id)->first();

        if (!$idea) {
            return redirect()
            ->route('ideas.index');
        }

        $validated = $this->validate($body);

        if ($validated->fails()) {
            return redirect()
                ->route('notes.index', ['idea_id' => $idea_id])
                ->withErrors($validated->errors())
                ->withInput();
        }

        $body['user_id'] = $user_id;
        $body['idea_id'] = $idea_id;
        $body['position'] = $idea->notes->count();

        Note::create($body);

        return redirect()->route('notes.index', ['idea_id' => $idea_id]);
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
    public function destroy($idea_id, $id)
    {
        $user_id = Auth::user()->id;

        $note = Note::where('idea_id', $idea_id)
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->first();

        if ($note) {
            $note->delete();

            $idea = Idea::where('id', $idea_id)
                ->where('user_id', $user_id)
                ->first();

            foreach ($idea->notes()->orderBy('position')->get() as $key => $note) {
                $note->position = $key;
                $note->save();
            }
        }

        return redirect()->route('notes.index', ['idea_id' => $idea_id]);
    }

    private function validate($body)
    {
        $rules = [
            'body' => 'required|min:3|max:5000',
        ];

        $messages = [
            'body.required' => 'O campo de nota é obrigatório',
            'body.min' => 'O campo de nota deve ter no mínimo 3 caracteres',
            'body.max' => 'O campo de título deve ter no máximo 5000 caracteres',
        ];

        return Validator::make($body, $rules, $messages);
    }
}
