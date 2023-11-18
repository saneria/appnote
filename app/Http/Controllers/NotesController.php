<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotesRequest;
use App\Models\Notes; 

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
    
        $user = auth()->user(); 
        $validated['user_id'] = $user->id;

        $note = Notes::create($validated);
    
        return $note;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return Notes::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Log::error("Note not found for ID: $id");

            return response()->json(['error' => 'Note not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotesRequest $request, $id)
    {
        try {
            // Retrieves
            $validated = $request->validated();

            // Find the note by ID
            $note = Notes::findOrFail($id);

            if ($note->user_id !== auth()->user()->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Update the note with the new data
            $note->update($validated);

            return $note;
        } catch (ModelNotFoundException $e) {
            Log::error("Note not found for ID: $id");

            return response()->json(['error' => 'Note not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = auth()->user();
    
            // Find the note with the given ID associated with the authenticated user
            $note = $user->notes()->findOrFail($id);
    
            // Delete the note
            $note->delete();
    
            return response()->json(['message' => 'Note deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Note not found'], 404);
        } catch (\Exception $e) {
            Log::error('Note deletion error: ' . $e->getMessage());
    
            return response()->json(['error' => 'Failed to delete the note'], 500);
        }
    }

    /**
     * Restore the specified soft-deleted resource.
     */
    public function restore(string $id)
    {
        $user = auth()->user();

        try {
           
            $note = $user->notes()->onlyTrashed()->findOrFail($id);

            // Restores note
            $note->restore();

            return $note;
        } catch (ModelNotFoundException $e) {

            Log::error("Note not found for ID: $id");
      
            return response()->json(['error' => 'Note not found'], 404);
        }
    }
}
