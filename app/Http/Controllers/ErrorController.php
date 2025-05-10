<?php

namespace App\Http\Controllers;

use App\Models\Error; // The model for the '404' table (Error model)
use Illuminate\Http\Request;

class ErrorController extends Controller
{

    public function index()
    {
        // Fetch all entries from the '404' table (Error model)
        $errors = Error::all();

        // Return the view with the list of errors
        return view('pages.error.index', compact('errors'));
    }


    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        // Create a new record in the '404' table
        Error::create([
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);

        // Redirect to the index page with a success message
        return redirect()->route('error.index')->with('success', 'Error record successfully added.');
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        // Find the error record by ID
        $error = Error::findOrFail($id);

        // Update the record in the database
        $error->update([
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);

        // Redirect back to the index page with a success message
        return redirect()->route('error.index')->with('success', 'Error record successfully updated.');
    }


    public function destroy($id)
    {
        // Find the error record by ID
        $error = Error::findOrFail($id);

        // Delete the record from the database
        $error->delete();

        // Redirect to the index page with a success message
        return redirect()->route('error.index')->with('success', 'Error record successfully deleted.');
    }
}