<?php
namespace App\Http\Controllers;

use App\Models\GambarProyek;
use App\Models\Proyek;
use App\Models\Tech;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function index()
    {
        // Fetch projects along with related images
        $proyek = Proyek::with('gambarProyek')->get();  // Ensure images are loaded along with the project

        $tech = Tech::all(); // Pass Tech data to the view

        return view('pages.proyek.index', compact('proyek', 'tech'));
    }

    // Menyimpan data proyek
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'thumbnail_proyek' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validate image
            'judul_proyek' => 'required|string|max:255',
            'jenis_proyek' => 'required|string|max:255',
            'teknologi' => 'required|array', // Ensure this is an array
            'detail_proyek' => 'required|string|max:255',
            'status' => 'required|string|in:Aktif,Nonaktif', // Ensure status is provided
        ]);

        // Handle the image upload for the project (thumbnail)
        $thumbnailImageName = uniqid(time() . '_') . '.' . $request->file('thumbnail_proyek')->extension();
        $request->file('thumbnail_proyek')->move(public_path('thumbnail_proyek'), $thumbnailImageName);

        // Store the project in the database
        $proyek = Proyek::create([
            'thumbnail_proyek' => 'thumbnail_proyek/' . $thumbnailImageName,  // Store the image path
            'judul_proyek' => $request->judul_proyek,
            'jenis_proyek' => $request->jenis_proyek,
            'teknologi' => implode(',', $request->teknologi),  // Convert array to string for storage
            'detail_proyek' => $request->detail_proyek,
            'status' => $request->status,
        ]);

        // After the project is created, automatically associate images with it (if provided)
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $gambarFile) {
                // Create a unique name for each image
                $gambarImageName = uniqid(time() . '_') . '.' . $gambarFile->extension();
                $gambarFile->move(public_path('images/gambar_proyek'), $gambarImageName);

                // Store the image record in the GambarProyek table
                GambarProyek::create([
                    'proyek_id' => $proyek->id,  // Automatically use the ID of the newly created proyek
                    'gambar_path' => 'gambar_proyek/' . $gambarImageName,  // Store the image path
                    'status' => $request->status,  // Use the same status as the project
                ]);
            }
        }

        return redirect()->route('proyek.index')->with('success', 'Data proyek dan gambar berhasil ditambahkan!');
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
            $imageName = uniqid(time() . '_') . '.' . $request->file('thumbnail_proyek')->extension();
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

        // Handle images deletion if specified
        if ($request->has('delete_gambar')) {
            foreach ($request->delete_gambar as $gambarId) {
                $gambar = GambarProyek::findOrFail($gambarId);
                if (file_exists(public_path($gambar->gambar_path))) {
                    unlink(public_path($gambar->gambar_path));  // Delete the image file
                }
                $gambar->delete();  // Delete the image record
            }
        }

        // Handle new images upload
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $gambarFile) {
                $gambarImageName = uniqid(time() . '_') . '.' . $gambarFile->extension();
                $gambarFile->move(public_path('images/gambar_proyek'), $gambarImageName);

                GambarProyek::create([
                    'proyek_id' => $proyek->id,
                    'gambar_path' => 'gambar_proyek/' . $gambarImageName,
                    'status' => $request->status,
                ]);
            }
        }

        return redirect()->route('proyek.index')->with('success', 'Data proyek berhasil diperbarui!');
    }

    // Menghapus data proyek
    public function destroy($id)
    {
        // Find the Proyek by ID
        $proyek = Proyek::findOrFail($id);

        // Delete thumbnail image file from the server
        if ($proyek->thumbnail_proyek && file_exists(public_path($proyek->thumbnail_proyek))) {
            unlink(public_path($proyek->thumbnail_proyek));
        }

        // Delete related GambarProyek images
        foreach ($proyek->gambarProyek as $gambar) {
            // Check if the image file exists, then delete it
            if (file_exists(public_path($gambar->gambar_path))) {
                unlink(public_path($gambar->gambar_path));  // Delete the image file
            }

            // Delete the GambarProyek record from the database
            $gambar->delete();
        }

        // Finally, delete the Proyek record
        $proyek->delete();

        // Redirect back with a success message
        return redirect()->route('proyek.index')->with('success', 'Data proyek beserta gambar-gambarnya berhasil dihapus!');
    }

}