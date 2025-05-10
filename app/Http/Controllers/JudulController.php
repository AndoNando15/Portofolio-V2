<?php
namespace App\Http\Controllers;

use App\Models\Judul;
use Illuminate\Http\Request;

class JudulController extends Controller
{
    public function index()
    {
        $judul = Judul::all();
        return view('pages.judul.index', compact('judul'));
    }

    // Menyimpan data judul
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kemampuan' => 'required|string|max:255',
        ]);

        $judul = Judul::create([
            'judul' => $request->judul,
            'kemampuan' => $request->kemampuan,
            'status' => 'Aktif', // Default status if necessary
        ]);

        return redirect()->route('judul.index')->with('success', 'Data berhasil ditambahkan.');
    }

    // Mengedit data judul
    public function update(Request $request, $id)
    {
        $judul = Judul::findOrFail($id);

        $judul->update([
            'judul' => $request->judul,
            'kemampuan' => $request->kemampuan,
            'status' => $request->status,
        ]);

        return redirect()->route('judul.index')->with('success', 'Data berhasil diupdate.');
    }

    // Menghapus data judul
    public function destroy($id)
    {
        $judul = Judul::findOrFail($id);
        $judul->delete();

        return redirect()->route('judul.index')->with('success', 'Data berhasil dihapus.');
    }
}