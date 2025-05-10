<?php

namespace App\Http\Controllers;

use App\Models\Tech;
use Illuminate\Http\Request;

class TechController extends Controller
{

    public function index()
    {
        // Fetch all records from 'tech' table
        $tech = Tech::all();

        // Return the view with the data
        return view('pages.proyek.subsubProyek.index', compact('tech'));
    }


    public function store(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'tech' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        // Create a new Tech entry
        Tech::create($validated);

        // Redirect to the index page with a success message
        return redirect()->route('subProyek.index')->with('success', 'Tech added successfully.');
    }




    public function update(Request $request, Tech $tech)
    {
        // Validate the input data
        $validated = $request->validate([
            'tech' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        // Update the record
        $tech->update($validated);

        // Redirect to the index page with a success message
        return redirect()->route('subProyek.index')->with('success', 'Tech updated successfully.');
    }


    public function destroy(Tech $tech)
    {
        // Delete the record
        $tech->delete();

        // Redirect to the index page with a success message
        return redirect()->route('subProyek.index')->with('success', 'Tech deleted successfully.');
    }
}