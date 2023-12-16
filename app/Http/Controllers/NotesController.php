<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NotesRequest;
use App\Models\Notes;
use Illuminate\Support\Str;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Notes::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotesRequest $request)
    {
        $validated = $request->validated();
        
        // Update the 'notes' field with the HTML content
        $validated['notes'] = $request->input('notes');
    
        $note = Notes::create($validated);
        return $note;
    }
    

    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        $note = Notes::where('user_id', $user_id)->get();
        return $note;
    }


    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(NotesRequest $request, string $id)
    {
        $validated = $request->validated();

        $note = Notes::findOrFail($id);

        $note-> update($validated);
                    

        return $note;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = Notes::findOrFail($id);
        $note->delete();
        return $note;
    }

    public function restore(string $id)
    {
        $note = Notes::withTrashed()->find($id);

        if ($note) {
            // Restores note
            $note->restore();

            return $note;
        }

        return response()->json(['error' => 'Note not found']);
        }   
}

