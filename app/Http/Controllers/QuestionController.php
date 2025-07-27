<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // GET /questions
    public function index(Request $request)
    {
     
            return Question::where('structure_id', auth()->user()->structure->id)
                ->orderByDesc('updated_at')
                ->get();
      
      
        
    }

    // POST /questions
    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'category' => 'required|string',
            'risk_category' => 'nullable|string',
            'color_code' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Set default risk_category if not provided
        if (!isset($data['risk_category']) || empty($data['risk_category'])) {
            $data['risk_category'] = 'general';
        }

        // Add user_id and structure_id
        $data['user_id'] = auth()->id();
        $data['structure_id'] = auth()->user()->structure->id;
        
        $question = Question::create($data);
        return response()->json($question, 201);
    }

    // PUT /questions/{id}
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $data = $request->validate([
            'question' => 'required|string',
            'category' => 'required|string',
            'risk_category' => 'nullable|string',
            'color_code' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Set default risk_category if not provided
        if (!isset($data['risk_category']) || empty($data['risk_category'])) {
            $data['risk_category'] = 'general';
        }

        $question->update($data);
        return response()->json($question);
    }

    // DELETE /questions/{id}
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return response()->json(['success' => true]);
    }
}
