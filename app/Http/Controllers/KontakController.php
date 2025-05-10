<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KontakController extends Controller
{
    // Display a listing of the contacts
    public function index(Request $request)
    {
        $kontak = Kontak::all(); // Get all contacts
        return view('pages.kontak.index', compact('kontak')); // Return the view with contacts
    }

    // Store a newly created contact in storage
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'icon_kontak' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_kontak' => 'required|string|max:255',
            'keterangan_kontak' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif',
            'url' => 'nullable|url|max:255' // Validate the URL field
        ]);

        // Handle file upload for icon_kontak
        if ($request->hasFile('icon_kontak')) {
            $imageName = time() . '.' . $request->icon_kontak->extension();
            $request->icon_kontak->move(public_path('images/kontak'), $imageName);  // Move the file to the folder
        }

        // Create a new Kontak entry in the database
        Kontak::create([
            'icon_kontak' => 'kontak/' . $imageName,  // Store the file path
            'nama_kontak' => $request->nama_kontak,
            'keterangan_kontak' => $request->keterangan_kontak,
            'status' => $request->status,
            'url' => $request->url, // Store the URL
        ]);

        return redirect()->route('kontak.index')->with('success', 'Kontak berhasil ditambahkan.');
    }

    // Update the specified contact in storage
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'icon_kontak' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_kontak' => 'required|string|max:255',
            'keterangan_kontak' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif',
            'url' => 'nullable|url|max:255' // Validate the URL field
        ]);

        $kontak = Kontak::findOrFail($id);  // Find the contact by ID

        // Handle file upload if a new image is uploaded
        if ($request->hasFile('icon_kontak')) {
            // Delete the old image if it exists
            if (Storage::exists($kontak->icon_kontak)) {
                Storage::delete($kontak->icon_kontak);
            }

            $imageName = time() . '.' . $request->icon_kontak->extension();
            $request->icon_kontak->move(public_path('images/kontak'), $imageName);
            $kontak->icon_kontak = 'kontak/' . $imageName;  // Update with the new image path
        }

        // Update the contact information, including the status and url field
        $kontak->update([
            'nama_kontak' => $request->nama_kontak,
            'keterangan_kontak' => $request->keterangan_kontak,
            'status' => $request->status,
            'url' => $request->url,  // Update the URL
        ]);

        return redirect()->route('kontak.index')->with('success', 'Kontak berhasil diperbarui.');
    }

    // Remove the specified contact
    public function destroy($id)
    {
        $kontak = Kontak::findOrFail($id);

        // Delete the image file if it exists
        if (Storage::exists($kontak->icon_kontak)) {
            Storage::delete($kontak->icon_kontak);
        }

        $kontak->delete();

        return redirect()->route('kontak.index')->with('success', 'Kontak berhasil dihapus.');
    }
}