<?php
namespace App\Http\Controllers;

use App\Models\GambarProyek;
use App\Models\Proyek;
use App\Models\Tech;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GambarProyekController extends Controller
{
    public function index()
    {
        // Fetch all records from 'gambar_proyek' table
        $gambarProyek = GambarProyek::all();
        // Get all projects for the dropdown
        $proyekList = Proyek::all();
        $tech = Tech::all();

        return view('pages.proyek.subProyek.index', compact('gambarProyek', 'proyekList', 'tech'));
    }

    public function store(Request $request) //gambarControler
    {
        // Validate the input data
        $validated = $request->validate([
            'proyek_id' => 'required|exists:proyek,id',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        // Handle file upload for gambar
        if ($request->hasFile('gambar')) {
            // Store the image in the 'gambar_proyek' directory inside 'public/thumbnail_proyek'
            $imageName = time() . '.' . $request->file('gambar')->extension();
            $request->file('gambar')->move(public_path('images/gambar_proyek'), $imageName);
        }

        // Create a new GambarProyek entry
        GambarProyek::create([
            'proyek_id' => $validated['proyek_id'],
            'gambar_path' => 'gambar_proyek/' . $imageName,  // Store the image path
            'status' => $validated['status'],
        ]);

        // Redirect to the index page with a success message
        return redirect()->route('subProyek.index')->with('success', 'Gambar Proyek created successfully.');
    }


    public function update(Request $request, $id)
    {
        // Validate input data
        $validated = $request->validate([
            'proyek_id' => 'required|exists:proyek,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        // Find the existing GambarProyek entry
        $gambarProyek = GambarProyek::findOrFail($id);

        // If there's a new image uploaded, handle the upload
        if ($request->hasFile('gambar')) {
            // Delete the old image if it exists
            if (Storage::exists($gambarProyek->gambar_path)) {
                Storage::delete($gambarProyek->gambar_path);
            }

            // Store the new image in 'gambar_proyek' directory inside 'public/thumbnail_proyek'
            $imageName = time() . '.' . $request->file('gambar')->extension();
            $request->file('gambar')->move(public_path('images/gambar_proyek'), $imageName);

            // Update image path
            $gambarProyek->gambar_path = 'gambar_proyek/' . $imageName;
        }

        // Update the record
        $gambarProyek->update([
            'proyek_id' => $validated['proyek_id'],
            'gambar_path' => $gambarProyek->gambar_path,
            'status' => $validated['status'],
        ]);

        // Redirect to the index page with a success message
        return redirect()->route('subProyek.index')->with('success', 'Gambar Proyek updated successfully.');
    }

    public function destroy($id)
    {
        // Find the GambarProyek record
        $gambarProyek = GambarProyek::findOrFail($id);

        // Delete the associated image file from the 'gambar_proyek' folder
        if (Storage::exists($gambarProyek->gambar_path)) {
            Storage::delete($gambarProyek->gambar_path);
        }

        // Delete the record
        $gambarProyek->delete();

        // Redirect to the index page with a success message
        return redirect()->route('subProyek.index')->with('success', 'Gambar Proyek deleted successfully.');
    }
}