<?php

namespace App\Http\Controllers;

use App\Models\TentangKamiGambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TentangKamiGambarController extends Controller
{
    // Display all images
    public function index()
    {
        $tentangKamiGambar = TentangKamiGambar::all();
        return view('pages.tentang-kami.index', compact('tentangKamiGambar'));
    }

    // Store new images
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|array|max:13',
            'gambar.*' => 'image|mimes:jpg,jpeg,png,gif|max:10240',
            'status' => 'required|string|in:Aktif,Nonaktif', // Validate status
        ]);

        // Store images in the 'gambar_tentang_kami' folder
        $gambar_paths = [];
        foreach ($request->file('gambar') as $gambar) {
            $gambar_paths[] = $gambar->store('gambar_tentang_kami', 'public');
        }

        // Create new entry with status
        TentangKamiGambar::create([
            'gambar' => json_encode($gambar_paths),
            'status' => $request->status, // Store status
        ]);

        return redirect()->route('tentang-kami.index')->with('success', 'Images uploaded successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'nullable|array|max:13',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'status' => 'required|string|in:Aktif,Nonaktif', // Validate status
        ]);

        $tentangKamiGambar = TentangKamiGambar::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $gambarPaths = json_decode($tentangKamiGambar->gambar, true);
            foreach ($gambarPaths as $path) {
                if (Storage::exists('public/' . $path)) {
                    Storage::delete('public/' . $path);
                }
            }

            // Store new images
            $gambar_paths = [];
            foreach ($request->file('gambar') as $gambar) {
                $gambar_paths[] = $gambar->store('gambar_tentang_kami', 'public');
            }

            $tentangKamiGambar->gambar = json_encode($gambar_paths);
        }

        // Update status
        $tentangKamiGambar->status = $request->status;
        $tentangKamiGambar->save();

        return redirect()->route('tentang-kami.index')->with('success', 'Images updated successfully.');
    }


    // Delete image(s)
    public function destroy($id)
    {
        $tentangKamiGambar = TentangKamiGambar::findOrFail($id);

        // Delete the images from storage
        $gambarPaths = json_decode($tentangKamiGambar->gambar, true);
        foreach ($gambarPaths as $path) {
            if (Storage::exists('public/' . $path)) {
                Storage::delete('public/' . $path);
            }
        }

        // Delete the record from the database
        $tentangKamiGambar->delete();

        return redirect()->route('tentang-kami.index')->with('success', 'Images deleted successfully.');
    }
}