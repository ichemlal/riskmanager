<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Metier;
use App\Models\Question;
use App\Models\Structure;
use App\Models\Salarie;

class MetiersController extends Controller
{
public function index()
{
    $user = auth()->user();
    $structure = null;
    
    // Get structure based on user role
    if ($user->hasRole('referent')) {
        $structure = Structure::where('user_id', $user->id)->first();
    } elseif ($user->hasRole('salarie') || $user->hasRole('employer')) {
        $salarie = Salarie::where('user_id', $user->id)->first();
        if ($salarie) {
            $structure = Structure::find($salarie->structure_id);
        }
    }
    
    if (!$structure) {
        abort(404, 'Structure not found');
    }
    
    // Get questions for this structure
    $questions = Question::where('structure_id', $structure->id)->get();
    
    // Get categories
    $categories = Question::where('structure_id', $structure->id)->distinct()->pluck('category');
    
    // Calculate statistics
    $stats = $this->calculateQuestionStats($structure);
    
    return view('bank')
        ->with('questions', $questions)
        ->with('categories', $categories)
        ->with('stats', $stats)
        ->with('structure', $structure);
}

/**
 * Calculate question bank statistics
 */
private function calculateQuestionStats($structure)
{
    // Total questions
    $totalQuestions = Question::where('structure_id', $structure->id)->count();
    
    // Active questions (questions that have been used in responses)
    $activeQuestions = Question::where('structure_id', $structure->id)
        ->whereHas('responses')
        ->count();
    
    // Categories count
    $categoriesCount = Question::where('structure_id', $structure->id)
        ->distinct('category')
        ->count();
    
    // Critical questions (questions with high risk responses - criticality > 15)
    $criticalQuestions = Question::where('structure_id', $structure->id)
        ->whereHas('responses', function($subQuery) {
            $subQuery->where('criticality', '>', 15);
        })
        ->count();
    
    return [
        'totalQuestions' => $totalQuestions,
        'activeQuestions' => $activeQuestions,
        'categoriesCount' => $categoriesCount,
        'criticalQuestions' => $criticalQuestions
    ];
}
    
public function store(Request $request)
{
    $user = auth()->user();
    $structure = null;
    
    // Get structure based on user role
    if ($user->hasRole('referent')) {
        $structure = Structure::where('user_id', $user->id)->first();
    } elseif ($user->hasRole('salarie') || $user->hasRole('employer')) {
        $salarie = Salarie::where('user_id', $user->id)->first();
        if ($salarie) {
            $structure = Structure::find($salarie->structure_id);
        }
    }
    
    if (!$structure) {
        return response()->json(['error' => 'Structure not found'], 404);
    }
    
    $data = $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        'icon' => 'nullable|string|max:10',
    ]);
    
    $data['structure_id'] = $structure->id;
    Metier::create($data);
    return response()->json(['success' => true]);
}

public function update(Request $request, $id)
{
    $data = $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        'icon' => 'nullable|string|max:10',
    ]);
    $metier = Metier::findOrFail($id);
    $metier->update($data);
    return response()->json(['success' => true]);
}
}
