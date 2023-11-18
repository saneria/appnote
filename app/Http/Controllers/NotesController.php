<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        //Retrieve the validated input data
        $validated = $request->validated();

        $notes = Notes::create($validated);

        return $notes;
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

        $notes = Notes::findOrFail($id);

        $notes->update($validated);

        return $notes;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        {
            $notes = Notes::findOrFail($id);
    
            $notes->delete();
    
            return $notes;
        }
    }
}
