<?php

namespace App\Http\Controllers;
use App\Models\Pesan;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index()
    {
        $pesan = Pesan::all();
        return view('pages.pesan.index', compact('pesan'));
    }

    // Menyimpan data pesan
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telepon' => 'required|string|max:255',
            'subjek' => 'required|string|max:255',
            'isi_pesan' => 'required|string',
            'status' => 'required|string|in:Aktif,Nonaktif', // Validate status

        ]);

        $pesan = Pesan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'subjek' => $request->subjek,
            'isi_pesan' => $request->isi_pesan,
            'status' => $request->status,
        ]);

        return redirect()->route('pesan.index')->with('success', 'Pesan successfully added!');
    }

    // Mengedit data pesan
    public function update(Request $request, $id)
    {
        $pesan = Pesan::findOrFail($id);

        $pesan->update([
            'nama' => $request->nama ?? $pesan->nama,
            'email' => $request->email ?? $pesan->email,
            'no_telepon' => $request->no_telepon ?? $pesan->no_telepon,
            'subjek' => $request->subjek ?? $pesan->subjek,
            'isi_pesan' => $request->isi_pesan ?? $pesan->isi_pesan,
            'status' => $request->status,

        ]);

        return redirect()->route('pesan.index')->with('success', 'Pesan successfully update!');
    }

    // Menghapus data pesan
    public function destroy($id)
    {
        $pesan = Pesan::findOrFail($id);
        $pesan->delete();

        return redirect()->route('pesan.index')->with('success', 'Data berhasil dihapus.');
    }
}