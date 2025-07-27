<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campagne;
use App\Models\Response;
use App\Models\Salarie;
use App\Models\Structure;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResultatsController extends Controller
{
    /**
     * Display results for a specific campaign
     * Accessible by both salariés (their own results) and référents (all results)
     */
    public function index($campaignId)
    {
        $user = auth()->user();
        
        // Get the campaign
        $campaign = Campagne::with(['questions', 'groupes'])->find($campaignId);
        if (!$campaign) {
            abort(404, 'Campagne non trouvée');
        }

        // Check if user has access to this campaign
        $hasAccess = false;
        $structure = null;
        
        if ($user->hasRole('referent')) {
            // For referents, find their structure
            $structure = Structure::where('user_id', $user->id)->first();
            if (!$structure) {
                abort(403, 'Aucune structure associée à votre compte');
            }

            // Référent can see all campaigns where their structure's salariés have participated
            $hasAccess = Response::where('campagne_id', $campaignId)
                              ->whereIn('salarie_id', function($query) use ($structure) {
                                  $query->select('id')->from('salaries')->where('structure_id', $structure->id);
                              })
                              ->exists();
            
            // Aussi permettre l'accès aux campagnes créées par le référent
            $hasAccess = $hasAccess || ($campaign->user_id == $user->id);
        } elseif ($user->hasRole('salarie') || $user->hasRole('employer')) {
            // For employees, find their salarie record
            $salarie = Salarie::where('user_id', $user->id)->first();
            if (!$salarie) {
                abort(403, 'Accès non autorisé');
            }
            $structure = Structure::find($salarie->structure_id);
            
            // Salarié can only see campaigns they have participated in
            $hasAccess = Response::where('campagne_id', $campaignId)
                              ->where('salarie_id', $salarie->id)
                              ->exists();
        }

        if (!$hasAccess) {
            abort(403, 'Accès non autorisé à cette campagne');
        }

        // Get results based on user role
        if ($user->hasRole('referent')) {
            return $this->getReferentResults($campaign, $structure);
        } else {
            $salarie = Salarie::where('user_id', $user->id)->first();
            return $this->getSalarieResults($campaign, $salarie);
        }
    }

    /**
     * Get results for a salarié (personal results)
     */
    private function getSalarieResults($campaign, $salarie)
    {
        $responses = Response::where('campagne_id', $campaign->id)
                            ->where('salarie_id', $salarie->id)
                            ->with('question')
                            ->get();

        $totalQuestions = $campaign->questions->count();
        $answeredQuestions = $responses->count();
        $completionRate = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;

        // Calculate risk statistics
        $riskStats = [
            'low' => $responses->where('criticality', '<=', 5)->count(),
            'medium' => $responses->whereBetween('criticality', [6, 10])->count(),
            'high' => $responses->whereBetween('criticality', [11, 15])->count(),
            'major' => $responses->whereBetween('criticality', [16, 20])->count(),
            'critical' => $responses->where('criticality', '>', 20)->count(),
        ];

        $averageCriticality = $responses->avg('criticality') ?: 0;
        $maxCriticality = $responses->max('criticality') ?: 0;

        // Get detailed responses with questions
        $detailedResponses = $responses->map(function($response) {
            return [
                'question' => $response->question->question,
                'category' => $response->question->category,
                'gravity' => $response->gravity,
                'frequency' => $response->frequency,
                'criticality' => $response->criticality,
                'criticality_level' => $this->getCriticalityLevel($response->criticality),
                'created_at' => $response->created_at
            ];
        });

        return view('results.salarie', compact(
            'campaign', 'responses', 'totalQuestions', 'answeredQuestions', 
            'completionRate', 'riskStats', 'averageCriticality', 'maxCriticality', 
            'detailedResponses'
        ));
    }

    /**
     * Get results for a référent (all participants results from their structure)
     */
    private function getReferentResults($campaign, $structure)
    {
        // CORRECTION: Get all responses for this campaign from salariés in the structure
        $responses = Response::where('campagne_id', $campaign->id)
                            ->whereIn('salarie_id', function($query) use ($structure) {
                                $query->select('id')->from('salaries')->where('structure_id', $structure->id);
                            })
                            ->with(['question', 'salarie'])
                            ->get();

        // Get all salariés from the structure (not just campaign groups)
        $allSalariesInStructure = Salarie::where('structure_id', $structure->id)->get();
        $totalParticipants = $allSalariesInStructure->count();
        
        $respondedParticipants = $responses->pluck('salarie_id')->unique()->count();
        
        $totalQuestions = $campaign->questions->count();
        
        // Overall statistics
        $globalStats = [
            'total_participants' => $totalParticipants,
            'responded_participants' => $respondedParticipants,
            'response_rate' => $totalParticipants > 0 ? round(($respondedParticipants / $totalParticipants) * 100) : 0,
            'total_questions' => $totalQuestions,
            'total_responses' => $responses->count(),
            'average_completion' => $totalParticipants > 0 ? round(($responses->count() / ($totalParticipants * $totalQuestions)) * 100) : 0
        ];

        // Risk distribution
        $riskDistribution = [
            'low' => $responses->where('criticality', '<=', 5)->count(),
            'medium' => $responses->whereBetween('criticality', [6, 10])->count(),
            'high' => $responses->whereBetween('criticality', [11, 15])->count(),
            'major' => $responses->whereBetween('criticality', [16, 20])->count(),
            'critical' => $responses->where('criticality', '>', 20)->count(),
        ];

        // Statistics by question
        $questionStats = $campaign->questions->map(function($question) use ($responses) {
            $questionResponses = $responses->where('question_id', $question->id);
            
            return [
                'question' => $question->question,
                'category' => $question->category,
                'response_count' => $questionResponses->count(),
                'average_gravity' => round($questionResponses->avg('gravity'), 1),
                'average_frequency' => round($questionResponses->avg('frequency'), 1),
                'average_criticality' => round($questionResponses->avg('criticality'), 1),
                'max_criticality' => $questionResponses->max('criticality'),
                'risk_distribution' => [
                    'low' => $questionResponses->where('criticality', '<=', 5)->count(),
                    'medium' => $questionResponses->whereBetween('criticality', [6, 10])->count(),
                    'high' => $questionResponses->whereBetween('criticality', [11, 15])->count(),
                    'major' => $questionResponses->whereBetween('criticality', [16, 20])->count(),
                    'critical' => $questionResponses->where('criticality', '>', 20)->count(),
                ]
            ];
        });

        // Statistics by participant - CORRECTION: tous les salariés de la structure
        $participantStats = collect();
        foreach ($allSalariesInStructure as $salarie) {
            $salarieResponses = $responses->where('salarie_id', $salarie->id);
            
            $participantStats->push([
                'salarie' => $salarie,
                'response_count' => $salarieResponses->count(),
                'completion_rate' => $totalQuestions > 0 ? round(($salarieResponses->count() / $totalQuestions) * 100) : 0,
                'average_criticality' => $salarieResponses->count() > 0 ? round($salarieResponses->avg('criticality'), 1) : 0,
                'max_criticality' => $salarieResponses->max('criticality') ?: 0,
                'high_risk_count' => $salarieResponses->where('criticality', '>', 15)->count(),
                'has_participated' => $salarieResponses->count() > 0
            ]);
        }

        return view('results.referent', compact(
            'campaign', 'globalStats', 'riskDistribution', 'questionStats', 
            'participantStats', 'responses'
        ));
    }

    /**
     * Get criticality level text
     */
    private function getCriticalityLevel($criticality)
    {
        if ($criticality <= 5) return 'Faible';
        if ($criticality <= 10) return 'Modéré';
        if ($criticality <= 15) return 'Élevé';
        if ($criticality <= 20) return 'Majeur';
        return 'Critique';
    }

    /**
     * Display overview of all campaigns and their results for referents
     */
    public function overview()
    {
        $user = auth()->user();
        
        // Only referents can access this overview
        if (!$user->hasRole('referent')) {
            abort(403, 'Accès réservé aux référents');
        }

        // Find the structure managed by this referent
        $structure = Structure::where('user_id', $user->id)->first();
        if (!$structure) {
            abort(403, 'Aucune structure associée à votre compte');
        }
        
        // Get all campaigns where structure's employees have participated
        $campaigns = Campagne::with(['questions', 'groupes'])
                             ->whereHas('responses', function($query) use ($structure) {
                                 $query->whereIn('salarie_id', function($subQuery) use ($structure) {
                                     $subQuery->select('id')->from('salaries')->where('structure_id', $structure->id);
                                 });
                             })
                             ->orWhere('user_id', $user->id) // Include campaigns created by this referent
                             ->get();

        $campaignStats = [];
        $globalStats = [
            'totalCampaigns' => $campaigns->count(),
            'totalResponses' => 0,
            'totalParticipants' => 0,
            'averageCompletionRate' => 0,
            'riskDistribution' => [
                'low' => 0,
                'medium' => 0,
                'high' => 0,
                'major' => 0,
                'critical' => 0
            ]
        ];

        foreach ($campaigns as $campaign) {
            // Get responses for this campaign from structure employees
            $responses = Response::where('campagne_id', $campaign->id)
                               ->whereIn('salarie_id', function($query) use ($structure) {
                                   $query->select('id')->from('salaries')->where('structure_id', $structure->id);
                               })
                               ->get();

            $participants = $responses->pluck('salarie_id')->unique()->count();
            $totalQuestions = $campaign->questions->count();
            $totalResponses = $responses->count();
            $completionRate = $totalQuestions > 0 ? round(($totalResponses / ($participants * $totalQuestions)) * 100) : 0;

            // Calculate risk distribution for this campaign
            $riskStats = [
                'low' => $responses->where('criticality', '<=', 5)->count(),
                'medium' => $responses->whereBetween('criticality', [6, 10])->count(),
                'high' => $responses->whereBetween('criticality', [11, 15])->count(),
                'major' => $responses->whereBetween('criticality', [16, 20])->count(),
                'critical' => $responses->where('criticality', '>', 20)->count(),
            ];

            $averageCriticality = $responses->avg('criticality') ?: 0;
            $maxCriticality = $responses->max('criticality') ?: 0;

            $campaignStats[] = [
                'id' => $campaign->id,
                'name' => $campaign->nom,
                'description' => $campaign->description,
                'participants' => $participants,
                'totalQuestions' => $totalQuestions,
                'totalResponses' => $totalResponses,
                'completionRate' => $completionRate,
                'averageCriticality' => round($averageCriticality, 1),
                'maxCriticality' => $maxCriticality,
                'riskStats' => $riskStats,
                'created_at' => $campaign->created_at,
                'status' => $campaign->status ?? 'active'
            ];

            // Add to global stats
            $globalStats['totalResponses'] += $totalResponses;
            $globalStats['totalParticipants'] += $participants;
            
            foreach ($riskStats as $level => $count) {
                $globalStats['riskDistribution'][$level] += $count;
            }
        }

        // Calculate average completion rate
        if ($campaignStats) {
            $globalStats['averageCompletionRate'] = round(
                collect($campaignStats)->avg('completionRate')
            );
        }

        return view('resultats.overview', compact('campaignStats', 'globalStats', 'structure'));
    }

    /**
     * Export results (general export)
     */
    public function export($campaignId)
    {
        // TODO: Implement general export functionality
        return response()->json(['message' => 'Export en développement']);
    }

    /**
     * Export results to PDF
     */
    public function exportPdf($campaignId)
    {
        // TODO: Implement PDF export
        return response()->json(['message' => 'Export PDF en développement']);
    }

    /**
     * Export results to Excel
     */
    public function exportExcel($campaignId)
    {
        // TODO: Implement Excel export
        return response()->json(['message' => 'Export Excel en développement']);
    }
}
