<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe; // Assurez-vous d'importer le modèle Groupe

class GroupesController extends Controller
{
   
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'membres' => 'nullable|array',
            'membres.*' => 'exists:salaries,id',
        ]);
        $data['structure_id'] = auth()->user()->structure->id;
        $groupe = Groupe::create($data);
        if (!empty($data['membres'])) {
            $groupe->salaries()->sync($data['membres']);
        }
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $groupe = Groupe::findOrFail($id);
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'membres' => 'nullable|array',
            'membres.*' => 'exists:salaries,id',
        ]);
        $groupe->update($data);
        if (isset($data['membres'])) {
            $groupe->salaries()->sync($data['membres']);
        }
        return response()->json(['success' => true]);
    }
}
