<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\IdeaShare;
use Illuminate\Http\Request;
use App\Models\Note;
use Carbon\Carbon;
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
            'created_at' => Carbon::parse($idea->created_at)->isoFormat('DD MMM. Y'),
            'ckeditor_key' => env('CKEDITOR_KEY_DEVELOPMENT'),
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

    public function downNote($idea_id, $note_id)
    {
        $this->changePosition($idea_id, $note_id, true);

        return redirect()->route('notes.index', ['idea_id' => $idea_id]);
    }

    public function upNote($idea_id, $note_id)
    {
        $this->changePosition($idea_id, $note_id);

        return redirect()->route('notes.index', ['idea_id' => $idea_id]);
    }

    private function changePosition($idea_id, $note_id, $is_down = false)
    {
        $note = Note::where('idea_id', $idea_id)
            ->where('id', $note_id)
            ->first();

        $noteDestination = Note::where('idea_id', $idea_id)
            ->where('position', $is_down ? $note->position + 1 : $note->position - 1)
            ->first();

        $position = $note->position;

        if ($noteDestination && $note) {
            $note->position = $noteDestination->position;
            $note->save();

            $noteDestination->position = $position;
            $noteDestination->save();
        }
    }

    public function ideaShared(string $token)
    {
        $ideaShare = IdeaShare::where('token', $token)->where('expires_in', '>', Carbon::now())->first();

        if (!$ideaShare) {
            return redirect()->back();
        }

        return view('note.index', [
            'idea' => $ideaShare->idea,
            'user' => $ideaShare->user,
            'ideaShare' => $ideaShare,
            'ckeditor_key' => env('CKEDITOR_KEY_DEVELOPMENT'),
            'isShared' => true,
            'created_at' => Carbon::parse($ideaShare->created_at)->isoFormat('DD MMM. Y'),
        ]);
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
