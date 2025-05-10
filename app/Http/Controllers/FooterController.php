<?php
namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $footer = Footer::all();
        return view('pages.footer.index', compact('footer'));
    }

    // Menyimpan data footer
    public function store(Request $request)
    {
        $request->validate([
            'footer' => 'required|string|max:255',
        ]);

        Footer::create([
            'footer' => $request->footer,
            'status' => $request->status,  // Pastikan status disimpan
        ]);

        return redirect()->route('footer.index')->with('success', 'Data berhasil ditambah.');
    }

    // Mengedit data footer
    public function update(Request $request, $id)
    {
        $footer = Footer::findOrFail($id);

        $footer->update([
            'footer' => $request->footer ?? $footer->footer,
            'status' => $request->status ?? $footer->status,
        ]);

        return redirect()->route('footer.index')->with('success', 'Data berhasil diupdate.');
    }

    // Menghapus data footer
    public function destroy($id)
    {
        $footer = Footer::findOrFail($id);
        $footer->delete();

        return redirect()->route('footer.index')->with('success', 'Data berhasil dihapus.');
    }
}