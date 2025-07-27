<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Structure;

class StructureController extends Controller
{
   public function index()
    {
        $structure = Structure::where('user_id', auth()->user()->id)->first(); // Récupère les structures de l'utilisateur connecté
        logger()->info('StructureController@index called by user: ' . auth()->user()->id);
        logger()->info('Structure:', ['structure' => $structure]);

        if (!$structure) {
            logger()->error('No structure found for user_id: ' . auth()->user()->id);
            abort(404, 'Structure not found');
        }
        return view('structure')->with('structure',$structure) ;// create resources/views/dashboard.blade.php
    }
 public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_structure' => 'required|string|max:255',
            'siret' => 'required|digits:14',
            'adresse' => 'required|string|max:255',
            'code_postal' => 'required|digits:5',
            'ville' => 'required|string|max:255',
            'email_contact' => 'required|email|max:255',
            'secteur_activite' => 'nullable|string|max:255',
            'nombre_employes' => 'nullable|string|max:255',
        ]);
        $validated['user_id'] = auth()->id(); // Associe l'utilisateur connecté à la structure
        Structure::create($validated);

        return redirect()->back()->with('success', 'Structure enregistrée avec succès !');
    }
}
