<?php
namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    // Display all skills with images
    public function index()
    {
        $skill = Skill::all();
        return view('pages.skill.index', compact('skill'));
    }

    // Store new skill with image
    public function store(Request $request)
    {
        $request->validate([
            'icon_skill' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate icon image
            'nama_skill' => 'required|string|max:255',
            'status' => 'required|string|in:Aktif,Nonaktif', // Validate status
        ]);

        // Store the image in the 'icons' folder inside the public directory
        $imageName = time() . '.' . $request->icon_skill->extension();
        $request->icon_skill->move(public_path('images/icons'), $imageName); // Store the image in public/images/icons

        // Create new skill record with status and image path
        Skill::create([
            'icon_skill' => $imageName,  // Save the image name in the database
            'nama_skill' => $request->nama_skill,
            'status' => $request->status,  // Save the status in the database
        ]);

        return redirect()->route('skill.index')->with('success', 'Skill successfully added!');
    }

    // Update existing skill and image
    public function update(Request $request, $id)
    {
        $request->validate([
            'icon_skill' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate icon image
            'nama_skill' => 'nullable|string|max:255',
            'status' => 'required|string|in:Aktif,Nonaktif', // Validate status
        ]);

        $skill = Skill::findOrFail($id);

        if ($request->hasFile('icon_skill')) {
            // Delete the old image if exists
            if (file_exists(public_path('images/icons/' . $skill->icon_skill))) {
                unlink(public_path('images/icons/' . $skill->icon_skill));
            }

            // Store the new image
            $imageName = time() . '.' . $request->icon_skill->extension();
            $request->icon_skill->move(public_path('images/icons'), $imageName);

            // Update image in the database
            $skill->icon_skill = $imageName;
        }

        // Update skill details
        $skill->nama_skill = $request->nama_skill ?? $skill->nama_skill;
        $skill->status = $request->status;

        // Save the updated skill
        $skill->save();

        return redirect()->route('skill.index')->with('success', 'Skill successfully updated!');
    }

    // Delete a skill and its image
    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);

        // Delete the image from the public/images/icons folder
        if (file_exists(public_path('images/icons/' . $skill->icon_skill))) {
            unlink(public_path('images/icons/' . $skill->icon_skill));
        }

        // Delete the skill record from the database
        $skill->delete();

        return redirect()->route('skill.index')->with('success', 'Skill successfully deleted!');
    }
}