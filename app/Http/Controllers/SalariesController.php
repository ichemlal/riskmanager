<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salarie;
use App\Models\Metier;
use App\Models\Groupe;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class SalariesController extends Controller
{
      public function index()
    {
        try {
            logger()->info('SalariesController@index called by user: ' . auth()->user()->id);

            $user = auth()->user();
            logger()->info('User:', ['user' => $user]);

            $structure = Structure::where('user_id', $user->id)->first();
            logger()->info('Structure:', ['structure' => $structure]);

            if (!$structure) {
                logger()->error('No structure found for user_id: ' . $user->id);
                abort(404, 'Structure not found');
            }

            $metiers = Metier::where('structure_id', $structure->id)->get();
            logger()->info('Metiers:', ['metiers' => $metiers]);

            $salaries = Salarie::where('structure_id', $structure->id)->with('metier')->get();
            logger()->info('Salaries:', ['salaries' => $salaries]);

            $groupes = Groupe::where('structure_id', $structure->id)->with('salaries')->get();
            logger()->info('Groupes:', ['groupes' => $groupes]);

            return view('parametre')
                ->with('salaries', $salaries)
                ->with('metiers', $metiers)
                ->with('groupes', $groupes)
                ->with('structure', $structure);

        } catch (\Exception $e) {
            logger()->error('Error in SalariesController@index: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Erreur interne du serveur');
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:salaries,email',
            'telephone' => 'nullable|string|max:30',
            'date_embauche' => 'nullable|date',
            'metier_id' => 'required|exists:metiers,id',
        ]);
        $data['structure_id'] = auth()->user()->structure->id;
        //create a user for the salarie
          $user = User::create([
            'name' => $data['prenom'] . ' ' . $data['nom'],
            'email' => $data['email'],
            'password' => Hash::make('password'), // Default password, can be changed later
        ]);
        // Assign the 'user' role to the newly registered user
        $user->addRole('employer');
        // Link the user to the salarie
        $data['user_id'] = $user->id;
        Salarie::create($data);
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $salarie = Salarie::findOrFail($id);
        $data = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:salaries,email,' . $id,
            'telephone' => 'nullable|string|max:30',
            'date_embauche' => 'nullable|date',
            'metier_id' => 'required|exists:metiers,id',
        ]);
        $salarie->update($data);
        return response()->json(['success' => true]);
    }
}
