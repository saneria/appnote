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
     * Show the form for creating a new resource.
     */
    public function store(NotesRequest $request)
    {
        // Retrieve the validated input data
        $validated = $request->validated();
    
        // Associate the note with the authenticated user
        $user = auth()->user(); 
        $validated['user_id'] = $user->id;
    
        // Create a new note with the associated user ID
        $note = Notes::create($validated);
    
        return $note;
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Notes::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotesRequest $request, string $id)
    {
        $validated = $request->validated();

        $note = Notes::findOrFail($id);

        $note->update($validated);

        return $note;
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
            // Log the error for further investigation
            Log::error('Note deletion error: ' . $e->getMessage());
    
            return response()->json(['error' => 'Failed to delete the note'], 500);
        }
    }

// restores note
        public function restore(string $id)
    {
        $user = auth()->user();

        // Find the soft-deleted note with the given ID associated with the authenticated user
        $note = $user->notes()->onlyTrashed()->findOrFail($id);

        // Restore the note
        $note->restore();

        return $note;
    }

}
