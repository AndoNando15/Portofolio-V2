<?php

namespace App\Http\Controllers;
use App\Models\Proyek;
use App\Models\Tech;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function index()
    {
        $proyek = Proyek::all();
        $tech = Tech::all(); // Pass Tech data to the view

        return view('pages.proyek.index', compact('proyek', 'tech'));
    }



    // Menyimpan data proyek
    public function store(Request $request)
    {
        // Debugging: Check all input data
        // dd($request->all());

        // Validate the request
        $request->validate([
            'thumbnail_proyek' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validate image
            'judul_proyek' => 'required|string|max:255',
            'jenis_proyek' => 'required|string|max:255',
            'teknologi' => 'required|array', // Ensure this is an array
            'detail_proyek' => 'required|string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('thumbnail_proyek')) {
            $imageName = time() . '.' . $request->file('thumbnail_proyek')->extension();
            // Store the image in the public folder
            $request->file('thumbnail_proyek')->move(public_path('thumbnail_proyek'), $imageName);

            // Save project in the database
            Proyek::create([
                'thumbnail_proyek' => 'thumbnail_proyek/' . $imageName,  // Save the image path
                'judul_proyek' => $request->judul_proyek,
                'jenis_proyek' => $request->jenis_proyek,
                'teknologi' => implode(',', $request->teknologi),  // Convert array to string for storage
                'detail_proyek' => $request->detail_proyek,
                'status' => $request->status,
            ]);

            // Redirect with success message
            return redirect()->route('proyek.index')->with('success', 'Data proyek berhasil ditambahkan!');
        }

        // If no image file is uploaded, return an error
        return back()->with('error', 'Thumbnail proyek harus diupload!');
    }


    // Mengedit data proyek
    public function update(Request $request, $id)
    {
        $proyek = Proyek::findOrFail($id);

        // Validate the request
        $request->validate([
            'thumbnail_proyek' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validate image if uploaded
            'judul_proyek' => 'required|string|max:255',
            'jenis_proyek' => 'required|string|max:255',
            'teknologi' => 'required|array', // Ensure the teknologi field is an array
            'detail_proyek' => 'required|string|max:255',
        ]);

        // Handle thumbnail upload if a new image is provided
        if ($request->hasFile('thumbnail_proyek')) {
            // Delete old image if exists
            if ($proyek->thumbnail_proyek && file_exists(public_path($proyek->thumbnail_proyek))) {
                unlink(public_path($proyek->thumbnail_proyek));  // Delete the old image
            }

            // Save new image
            $imageName = time() . '.' . $request->file('thumbnail_proyek')->extension();
            $request->file('thumbnail_proyek')->move(public_path('thumbnail_proyek'), $imageName);  // Store the new image

            // Update the record with the new image path
            $proyek->thumbnail_proyek = 'thumbnail_proyek/' . $imageName;  // Save the new image path
        }

        // Update the rest of the project data
        $proyek->update([
            'judul_proyek' => $request->judul_proyek,
            'jenis_proyek' => $request->jenis_proyek,
            'teknologi' => implode(',', $request->teknologi),  // Store technologies as a comma-separated string
            'detail_proyek' => $request->detail_proyek,
            'status' => $request->status,
        ]);

        return redirect()->route('proyek.index')->with('success', 'Data proyek berhasil diperbarui!');
    }


    // Menghapus data proyek
    public function destroy($id)
    {
        $proyek = Proyek::findOrFail($id);

        // Delete image file from the server
        if ($proyek->thumbnail_proyek && file_exists(public_path($proyek->thumbnail_proyek))) {
            unlink(public_path($proyek->thumbnail_proyek));
        }

        $proyek->delete();

        return redirect()->route('proyek.index')->with('success', 'Data proyek berhasil dihapus!');
    }
}