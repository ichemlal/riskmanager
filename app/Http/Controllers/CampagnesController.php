<?php

namespace App\Http\Controllers;
use App\Models\Salarie;
use App\Models\Metier;
use App\Models\Groupe;
use App\Models\Structure;
use App\Models\Campagne;
use App\Models\User;
use App\Models\Question;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 

use Illuminate\Http\Request;

class CampagnesController extends Controller
{
    public function index()
    {   
        $user = auth()->user();
        logger()->info('User:', ['user' => $user]);
        
        $structure = null;
        
        // Check if user is a referent
        if ($user->hasRole('referent')) {
            $structure = Structure::where('user_id', $user->id)->first();
            logger()->info('Structure (referent):', ['structure' => $structure]);
        } 
        // Check if user is a salarie
        elseif ($user->hasRole('salarie') || $user->hasRole('employer')) {
            $salarie = Salarie::where('user_id', $user->id)->first();
            if ($salarie) {
                logger()->info('Salarie:', ['salarie' => $salarie->id]);
                $structure = Structure::find($salarie->structure_id);
                logger()->info('Structure (salarie):', ['structure' => $structure]);
            }
        }

        if (!$structure) {
            logger()->error('No structure found for user_id: ' . $user->id);
            abort(404, 'Structure not found');
        }

        $metiers = Metier::where('structure_id', $structure->id)->get();
        logger()->info('Metiers:', ['metiers' => $metiers]);

        $salaries = Salarie::where('structure_id', $structure->id)->with('metier')->get();
        logger()->info('Salaries:', ['salaries' => $salaries]);

        $groupes = Groupe::where('structure_id', $structure->id)->with('salaries')->withCount('salaries')->get();
        logger()->info('Groupes:', ['groupes' => $groupes]);
        
        //campagnes - CORRECTION: filtrer selon le rôle utilisateur
        if ($user->hasRole('referent')) {
            // Pour le référent : toutes les campagnes créées par lui OU avec responses des salariés de sa structure
            $campagnes = Campagne::with(['groupes', 'user', 'responses' => function($query) use ($structure) {
                $query->whereIn('salarie_id', function($subQuery) use ($structure) {
                    $subQuery->select('id')->from('salaries')->where('structure_id', $structure->id);
                });
            }])
            ->where(function($query) use ($structure, $user) {
                // Campagnes créées par ce référent
                $query->where('user_id', $user->id)
                // OU campagnes avec des réponses de salariés de cette structure
                ->orWhereHas('responses', function($subQuery) use ($structure) {
                    $subQuery->whereIn('salarie_id', function($subSubQuery) use ($structure) {
                        $subSubQuery->select('id')->from('salaries')->where('structure_id', $structure->id);
                    });
                });
            })
            ->latest()->get();
        } else {
            // Pour les employés : campagnes auxquelles ils ont accès
            $campagnes = Campagne::with(['groupes', 'user'])->whereHas('groupes', function($query) use ($structure) {
                $query->where('structure_id', $structure->id);
            })->latest()->get();
        }
        logger()->info('Campagnes:', ['campagnes' => $campagnes]);
        
        //questions
        $questions = Question::where('structure_id', $structure->id)->get();
        $categories = Question::where('structure_id', $structure->id)->distinct()->pluck('category');
        logger()->info('Questions:', ['questions' => $questions]);
        
        // Calculate statistics for referent view
        $stats = $this->calculateCampaignStats($structure, $user);
        
        return view('campagne')
            ->with('salaries', $salaries)
            ->with('metiers', $metiers)
            ->with('groupes', $groupes)
            ->with('structure', $structure)
            ->with('campagnes', $campagnes)
            ->with('questions', $questions)
            ->with('categories', $categories)
            ->with('stats', $stats);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'groupes' => 'array',
            'groupes.*' => 'exists:groupes,id',
            'emails' => 'nullable|string',
            'participants' => 'required|integer|min:1',
            'questions' => 'array',
            'questions.*' => 'exists:questions,id',
        ]);

        $campagne = \App\Models\Campagne::create([
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? '',
            'date_debut' => $validated['date_debut'],
            'date_fin' => $validated['date_fin'],
            'participants' => $validated['participants'],
            'user_id' => auth()->id(),
        ]);

        if (!empty($validated['groupes'])) {
            $campagne->groupes()->sync($validated['groupes']);
        }

        if (!empty($validated['emails'])) {
            $emails = array_map('trim', explode(',', $validated['emails']));
            $campagne->emails = json_encode($emails);
            $campagne->save();
        }

        if (!empty($validated['questions'])) {
            $campagne->questions()->sync($validated['questions']);
        }

        return response()->json(['success' => true, 'campagne_id' => $campagne->id]);
    }
    
    public function update(Request $request, $id)
    {
        // Logic to update an existing campaign
        $campaign = \App\Models\Campaign::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Add other fields as necessary
        ]);
        
        $campaign->update($validated);

        return redirect()->back()->with('success', 'Campaign updated successfully!');
    }
    
    public function destroy($id)
    {
        // Logic to delete a campaign
        $campaign = \App\Models\Campaign::findOrFail($id);
        $campaign->delete();

        return redirect()->back()->with('success', 'Campaign deleted successfully!');
    }
    public function quiz()
    {
        // Logic to display the quiz view
        $user = Salarie::where('user_id', auth()->id())->first();
        if (!$user) {
            abort(404, 'Salarie record not found');
        }
        
        $structure = Structure::find($user->structure_id);
        
        // Get campaigns with questions and progress calculation
        $campaigns = Campagne::whereHas('groupes', function ($query) use ($user) {
            $query->whereHas('salaries', function ($query) use ($user) {
                $query->where('salaries.id', $user->id);
            });
        })->with(['questions', 'groupes'])->get();

        // Add progress and completion status for each campaign
        $campaigns = $campaigns->map(function ($campaign) use ($user) {
            $totalQuestions = $campaign->questions->count();
            
            // Count answered questions for this user
            $answeredQuestions = DB::table('responses')
                ->where('campagne_id', $campaign->id)
                ->where('salarie_id', $user->id)
                ->distinct('question_id')
                ->count();
            
            // Calculate progress percentage
            $userProgress = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;
            
            // Check if completed
            $isCompleted = $answeredQuestions >= $totalQuestions && $totalQuestions > 0;
            $completedAt = null;
            
            if ($isCompleted) {
                $lastResponse = DB::table('responses')
                    ->where('campagne_id', $campaign->id)
                    ->where('salarie_id', $user->id)
                    ->orderBy('updated_at', 'desc')
                    ->first();
                $completedAt = $lastResponse ? $lastResponse->updated_at : now();
            }
            
            // Add calculated fields
            $campaign->user_progress = $userProgress;
            $campaign->completed_at = $completedAt;
            $campaign->status = $isCompleted ? 'completed' : ($userProgress > 0 ? 'active' : 'pending');
            
            // Add some metadata
            $campaign->title = $campaign->nom;
            $campaign->estimated_duration = ceil($totalQuestions * 0.5); // 30 seconds per question
            $campaign->deadline = $campaign->date_fin;
            
            return $campaign;
        });

        logger()->info('Campaigns for user:', ['user_id' => $user->id, 'campaigns_count' => $campaigns->count()]);
        return view('quiz', compact('campaigns', 'structure'));
    }

    public function submitQuiz(Request $request)
    {
        try {
            // Log the incoming request
            Log::info('Quiz submission received:', $request->all());

            // Validate the request
            $validated = $request->validate([
                'campaign_id' => 'required|integer',
                'answers' => 'required|array',
                'completed_at' => 'required|string'
            ]);

            $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            // Get user's salarie record
            $salarie = Salarie::where('user_id', $user->id)->first();
            if (!$salarie) {
                return response()->json(['success' => false, 'message' => 'Salarie record not found'], 404);
            }

            // Verify campaign exists and user has access
            $campaign = Campagne::whereHas('groupes', function ($query) use ($salarie) {
                $query->whereHas('salaries', function ($query) use ($salarie) {
                    $query->where('salaries.id', $salarie->id);
                });
            })->with('questions')->find($validated['campaign_id']);

            if (!$campaign) {
                return response()->json(['success' => false, 'message' => 'Campaign not found or access denied'], 404);
            }

            $savedCount = 0;
            $updatedCount = 0;

            // Process and save answers
            foreach ($validated['answers'] as $questionIndex => $answer) {
                if (isset($answer['gravity']) && isset($answer['frequency'])) {
                    // Get the question ID from the campaign questions
                    $questions = $campaign->questions->toArray();
                    if (!isset($questions[$questionIndex])) {
                        continue; // Skip if question doesn't exist
                    }
                    
                    $questionId = $questions[$questionIndex]['id'];
                    
                    // Calculate criticality
                    $criticality = $answer['gravity'] * $answer['frequency'];
                    
                    // Save or update response
                    $response = \App\Models\Response::updateOrCreate(
                        [
                            'campagne_id' => $validated['campaign_id'],
                            'question_id' => $questionId,
                            'salarie_id' => $salarie->id,
                        ],
                        [
                            'gravity' => $answer['gravity'],
                            'frequency' => $answer['frequency'],
                            'criticality' => $criticality
                        ]
                    );

                    if ($response->wasRecentlyCreated) {
                        $savedCount++;
                    } else {
                        $updatedCount++;
                    }

                    Log::info('Response saved:', [
                        'campaign_id' => $validated['campaign_id'],
                        'question_id' => $questionId,
                        'user_id' => $user->id,
                        'salarie_id' => $salarie->id,
                        'question_index' => $questionIndex,
                        'gravity' => $answer['gravity'],
                        'frequency' => $answer['frequency'],
                        'criticality' => $criticality,
                        'action' => $response->wasRecentlyCreated ? 'created' : 'updated'
                    ]);
                }
            }

            // Calculate completion status
            $totalQuestions = $campaign->questions->count();
            $answeredQuestions = DB::table('responses')
                ->where('campagne_id', $validated['campaign_id'])
                ->where('salarie_id', $salarie->id)
                ->distinct('question_id')
                ->count();

            $completionPercentage = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;
            $isCompleted = $answeredQuestions >= $totalQuestions && $totalQuestions > 0;

            return response()->json([
                'success' => true,
                'message' => 'Quiz submitted successfully',
                'data' => [
                    'campaign_id' => $validated['campaign_id'],
                    'total_questions' => $totalQuestions,
                    'answered_questions' => $answeredQuestions,
                    'completion_percentage' => $completionPercentage,
                    'is_completed' => $isCompleted,
                    'responses_saved' => $savedCount,
                    'responses_updated' => $updatedCount,
                    'completed_at' => $validated['completed_at']
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Quiz submission error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show results summary for current salarié
     */
    public function mesResultats()
    {
        $user = auth()->user();
        $salarie = Salarie::where('user_id', $user->id)->first();
        
        if (!$salarie) {
            abort(403, 'Accès non autorisé - profil salarié requis');
        }

        // Get all campaigns the salarié is assigned to
        $campaigns = Campagne::whereHas('groupes', function ($query) use ($salarie) {
            $query->whereHas('salaries', function ($query) use ($salarie) {
                $query->where('salaries.id', $salarie->id);
            });
        })->with(['questions', 'groupes'])->get();

        // Add progress and completion status for each campaign
        $campaignsWithResults = $campaigns->map(function ($campaign) use ($salarie) {
            $totalQuestions = $campaign->questions->count();
            
            // Count answered questions for this user
            $answeredQuestions = DB::table('responses')
                ->where('campagne_id', $campaign->id)
                ->where('salarie_id', $salarie->id)
                ->distinct('question_id')
                ->count();
            
            // Calculate progress percentage
            $userProgress = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;
            
            // Check if completed
            $isCompleted = $answeredQuestions >= $totalQuestions && $totalQuestions > 0;
            
            // Get responses for statistics
            $responses = Response::where('campagne_id', $campaign->id)
                                ->where('salarie_id', $salarie->id)
                                ->get();
            
            $averageCriticality = $responses->avg('criticality') ?: 0;
            $maxCriticality = $responses->max('criticality') ?: 0;
            $highRiskCount = $responses->where('criticality', '>', 15)->count();
            
            // Add calculated fields
            $campaign->user_progress = $userProgress;
            $campaign->is_completed = $isCompleted;
            $campaign->status = $isCompleted ? 'completed' : ($userProgress > 0 ? 'active' : 'pending');
            $campaign->answered_questions = $answeredQuestions;
            $campaign->total_questions = $totalQuestions;
            $campaign->average_criticality = round($averageCriticality, 1);
            $campaign->max_criticality = $maxCriticality;
            $campaign->high_risk_count = $highRiskCount;
            
            return $campaign;
        });

        return view('results.mes-resultats', compact('campaignsWithResults', 'salarie'));
    }

    /**
     * Calculate campaign statistics for referent dashboard
     */
    private function calculateCampaignStats($structure, $user)
    {
        // Get all campaigns with responses from structure employees
        $allCampaigns = Campagne::whereHas('responses', function($query) use ($structure) {
            $query->whereIn('salarie_id', function($subQuery) use ($structure) {
                $subQuery->select('id')->from('salaries')->where('structure_id', $structure->id);
            });
        })->orWhere('user_id', $user->id)->get();

        // 1. Active Campaigns (campaigns with recent responses or created in last 30 days)
        $activeCampaigns = $allCampaigns->filter(function($campaign) use ($structure) {
            $hasRecentActivity = Response::where('campagne_id', $campaign->id)
                ->whereIn('salarie_id', function($query) use ($structure) {
                    $query->select('id')->from('salaries')->where('structure_id', $structure->id);
                })
                ->where('created_at', '>=', now()->subDays(30))
                ->exists();
            
            $isRecentCampaign = $campaign->created_at >= now()->subDays(30);
            
            return $hasRecentActivity || $isRecentCampaign;
        })->count();

        // 2. Trained Employees (employees who have participated in at least one campaign)
        $trainedEmployees = Salarie::where('structure_id', $structure->id)
            ->whereHas('responses')
            ->count();

        // 3. Participation Rate
        $totalEmployees = Salarie::where('structure_id', $structure->id)->count();
        $participationRate = $totalEmployees > 0 ? round(($trainedEmployees / $totalEmployees) * 100) : 0;

        // 4. Urgent Campaigns (campaigns with high-risk responses or low completion rates)
        $urgentCampaigns = $allCampaigns->filter(function($campaign) use ($structure) {
            // Check for high-risk responses (criticality > 15)
            $hasHighRiskResponses = Response::where('campagne_id', $campaign->id)
                ->whereIn('salarie_id', function($query) use ($structure) {
                    $query->select('id')->from('salaries')->where('structure_id', $structure->id);
                })
                ->where('criticality', '>', 15)
                ->exists();

            // Check completion rate
            $totalQuestions = $campaign->questions()->count();
            $totalResponses = Response::where('campagne_id', $campaign->id)
                ->whereIn('salarie_id', function($query) use ($structure) {
                    $query->select('id')->from('salaries')->where('structure_id', $structure->id);
                })
                ->count();
            
            $participants = Response::where('campagne_id', $campaign->id)
                ->whereIn('salarie_id', function($query) use ($structure) {
                    $query->select('id')->from('salaries')->where('structure_id', $structure->id);
                })
                ->distinct('salarie_id')
                ->count();

            $expectedResponses = $participants * $totalQuestions;
            $completionRate = $expectedResponses > 0 ? ($totalResponses / $expectedResponses) * 100 : 0;
            
            return $hasHighRiskResponses || $completionRate < 50;
        })->count();

        return [
            'activeCampaigns' => $activeCampaigns,
            'trainedEmployees' => $trainedEmployees,
            'participationRate' => $participationRate,
            'urgentCampaigns' => $urgentCampaigns,
            'totalEmployees' => $totalEmployees,
            'totalCampaigns' => $allCampaigns->count()
        ];
    }
}

