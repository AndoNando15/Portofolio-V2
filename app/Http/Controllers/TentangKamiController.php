<?php

namespace App\Http\Controllers;
use App\Models\TentangKami;
use App\Models\TentangKamiGambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TentangKamiController extends Controller
{
    // Show all data
    public function index()
    {
        $tentangKami = TentangKami::all();
        $tentangKamiGambar = TentangKamiGambar::all();
        return view('pages.tentang-kami.index', compact('tentangKami', 'tentangKamiGambar'));
    }

    // Store new data
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'deskripsi_cv' => 'required|string|max:255',
            'file_cv' => 'required|file|mimes:pdf|max:10240', // Validate PDF file upload
            'status' => 'required|string|in:Aktif,Nonaktif',
        ]);

        // Handle file upload and store it in the 'file_cv' folder
        $fileCv = $request->file('file_cv');
        $filePath = $fileCv->store('file_cv', 'public'); // Store in 'file_cv' folder

        TentangKami::create([
            'nama_lengkap' => $request->nama_lengkap,
            'pekerjaan' => $request->pekerjaan,
            'deskripsi_cv' => $request->deskripsi_cv,
            'file_cv' => $filePath,
            'status' => $request->status,
        ]);

        return redirect()->route('tentang-kami.index')->with('success', 'Data berhasil ditambahkan.');
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'deskripsi_cv' => 'required|string|max:255',
            'file_cv' => 'nullable|file|mimes:pdf|max:10240', // Optional, only if file is uploaded
            'status' => 'required|string|in:Aktif,Nonaktif',
        ]);

        $tentangKami = TentangKami::findOrFail($id);

        // Handle file upload if present
        if ($request->hasFile('file_cv')) {
            // Delete old file if it exists
            if ($tentangKami->file_cv && Storage::exists('public/' . $tentangKami->file_cv)) {
                Storage::delete('public/' . $tentangKami->file_cv);
            }

            // Store new file in the 'file_cv' folder
            $fileCv = $request->file('file_cv');
            $filePath = $fileCv->store('file_cv', 'public'); // Store in 'file_cv' folder
            $tentangKami->file_cv = $filePath;
        }

        // Update other fields
        $tentangKami->update([
            'nama_lengkap' => $request->nama_lengkap,
            'pekerjaan' => $request->pekerjaan,
            'deskripsi_cv' => $request->deskripsi_cv,
            'status' => $request->status,
        ]);

        return redirect()->route('tentang-kami.index')->with('success', 'Data berhasil diperbarui.');
    }

    // Delete data
    public function destroy($id)
    {
        $tentangKami = TentangKami::findOrFail($id);

        // Delete the file if it exists
        if ($tentangKami->file_cv && Storage::exists('public/' . $tentangKami->file_cv)) {
            Storage::delete('public/' . $tentangKami->file_cv);
        }

        $tentangKami->delete();

        return redirect()->route('tentang-kami.index')->with('success', 'Data berhasil dihapus.');
    }
}