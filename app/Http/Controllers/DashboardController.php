<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Structure;
use App\Models\User;
use App\Models\Campagne;
use App\Models\Response;
use App\Models\Salarie;
use App\Models\Metier;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Log the user ID for debugging
        logger()->info('DashboardController@index called by user: ' . auth()->user()->id);  
        
        // if user is referent
        if (auth()->user()->hasRole('referent')) {
            $structure = Structure::where('user_id', auth()->user()->id)->first(); 
            
            if (!$structure) {
                return view('structure')->with('structure', $structure);
            }

            // Calculer les vraies statistiques pour le référent
            $stats = $this->calculateReferentStats($structure);
            
            return view('dashboard', compact('stats'));
        }
        
        // if user is employer
        if (auth()->user()->hasRole('employer')) {
            // Calculer les stats pour l'employé
            $stats = $this->calculateEmployerStats();
            return view('userdash', compact('stats'));
        }
        else {
            // if user is admin
            return 'invite';
        }
    }

    private function calculateReferentStats($structure)
    {
        // Récupérer tous les salariés de cette structure
        $totalSalaries = Salarie::where('structure_id', $structure->id)->count();
        
        // Récupérer les campagnes pour cette structure (campagnes créées par le référent OU avec des réponses de sa structure)
        $totalCampagnes = Campagne::where(function($query) use ($structure) {
            // Campagnes créées par ce référent
            $query->where('user_id', auth()->user()->id)
            // OU campagnes avec des réponses de salariés de cette structure
            ->orWhereHas('responses', function($subQuery) use ($structure) {
                $subQuery->whereIn('salarie_id', function($subSubQuery) use ($structure) {
                    $subSubQuery->select('id')->from('salaries')->where('structure_id', $structure->id);
                });
            });
        })->count();
        
        // Calculer le taux de participation de TOUS les salariés de la structure
        $totalResponses = Response::whereIn('salarie_id', function($query) use ($structure) {
            $query->select('id')->from('salaries')->where('structure_id', $structure->id);
        })->distinct('salarie_id')->count();
        
        $tauxParticipation = $totalSalaries > 0 ? round(($totalResponses / $totalSalaries) * 100, 1) : 0;
        
        // Récupérer les métiers analysés dans cette structure
        $metiersAnalyses = Metier::where('structure_id', $structure->id)->count();
        
        // Calculer les risques critiques pour TOUS les salariés de la structure
        $risquesCritiques = Response::whereIn('salarie_id', function($query) use ($structure) {
            $query->select('id')->from('salaries')->where('structure_id', $structure->id);
        })->whereRaw('gravity * frequency >= 16')->count();
        
        // Récupérer la répartition des risques par campagne pour tous les salariés de la structure
        $repartitionCampagnes = Response::select(
            'campagnes.nom as campagne',
            DB::raw('COUNT(*) as total_responses'),
            DB::raw('AVG(gravity * frequency) as risk_score')
        )
        ->join('campagnes', 'responses.campagne_id', '=', 'campagnes.id')
        ->whereIn('responses.salarie_id', function($query) use ($structure) {
            $query->select('id')->from('salaries')->where('structure_id', $structure->id);
        })
        ->groupBy('campagnes.id', 'campagnes.nom')
        ->get();
        
        // Récupérer les alertes récentes pour toute la structure
        $alertes = $this->getRecentAlerts($structure);

        return [
            'total_participants' => $totalResponses,
            'taux_participation' => $tauxParticipation,
            'metiers_analyses' => $metiersAnalyses,
            'risques_critiques' => $risquesCritiques,
            'repartition_metiers' => $repartitionCampagnes, // Renommé pour la vue
            'alertes' => $alertes,
            'total_salaries' => $totalSalaries,
            'total_campagnes' => $totalCampagnes
        ];
    }

    private function calculateEmployerStats()
    {
        $user = auth()->user();
        
        // Récupérer le salarié associé à cet utilisateur
        $salarie = Salarie::where('user_id', $user->id)->first();
        
        // Debug logging
        logger()->info('CalculateEmployerStats - User ID: ' . $user->id);
        logger()->info('CalculateEmployerStats - Salarie found: ' . ($salarie ? 'Yes' : 'No'));
        
        if (!$salarie) {
            return [
                'mes_campagnes' => 0,
                'campagnes_completes' => 0,
                'taux_completion' => 0,
                'mon_score_risque' => 0
            ];
        }

        logger()->info('CalculateEmployerStats - Salarie structure_id: ' . $salarie->structure_id);

        // CORRECTION: Compter seulement les campagnes ASSIGNÉES au salarié
        // Méthode 1: Si le salarié a participé, c'est qu'elles lui étaient assignées
        $campagnesAssignees = Response::where('salarie_id', $salarie->id)
            ->distinct('campagne_id')
            ->count();
        
        // Si aucune campagne complétée, utiliser les campagnes de sa structure
        if ($campagnesAssignees == 0) {
            $structureReferent = User::whereHas('structure', function($query) use ($salarie) {
                $query->where('id', $salarie->structure_id);
            })->first();
            
            if ($structureReferent) {
                $campagnesAssignees = Campagne::where('user_id', $structureReferent->id)->count();
            }
        }
        
        // Compter les campagnes auxquelles ce salarié a répondu
        $campagnesCompletes = Response::where('salarie_id', $salarie->id)
            ->distinct('campagne_id')
            ->count();
        
        logger()->info('CalculateEmployerStats - Campagnes assignées: ' . $campagnesAssignees);
        logger()->info('CalculateEmployerStats - Campagnes completes: ' . $campagnesCompletes);
        
        $tauxCompletion = $campagnesAssignees > 0 ? round(($campagnesCompletes / $campagnesAssignees) * 100, 1) : 0;
        
        // Calculer le score de risque moyen de ce salarié
        $monScoreRisque = Response::where('salarie_id', $salarie->id)
            ->selectRaw('AVG(gravity * frequency) as avg_score')
            ->value('avg_score') ?? 0;

        logger()->info('CalculateEmployerStats - Taux completion: ' . $tauxCompletion);
        logger()->info('CalculateEmployerStats - Score risque: ' . $monScoreRisque);

        return [
            'mes_campagnes' => $campagnesAssignees,
            'campagnes_completes' => $campagnesCompletes,
            'taux_completion' => $tauxCompletion,
            'mon_score_risque' => round($monScoreRisque, 1)
        ];
    }

    private function getRecentAlerts($structure)
    {
        $alertes = [];
        
        // Risques critiques récents pour TOUS les salariés de la structure
        $risquesCritiquesRecents = Response::whereIn('salarie_id', function($query) use ($structure) {
            $query->select('id')->from('salaries')->where('structure_id', $structure->id);
        })
        ->whereRaw('gravity * frequency >= 16')
        ->with(['campagne', 'salarie'])
        ->latest()
        ->take(3)
        ->get();
        
        foreach ($risquesCritiquesRecents as $response) {
            $alertes[] = [
                'type' => 'critical',
                'title' => 'Risque critique détecté',
                'description' => 'Score de risque élevé (' . ($response->gravity * $response->frequency) . ') pour ' . ($response->salarie->prenom ?? 'Salarié') . ' dans la campagne ' . $response->campagne->nom,
                'created_at' => $response->created_at
            ];
        }
        
        // Campagnes sans réponses (toutes les campagnes, pas seulement celles du référent)
        $campagnesSansReponses = Campagne::doesntHave('responses')
            ->take(2)
            ->get();
            
        foreach ($campagnesSansReponses as $campagne) {
            $alertes[] = [
                'type' => 'warning',
                'title' => 'Campagne sans réponses',
                'description' => 'La campagne "' . $campagne->nom . '" n\'a reçu aucune réponse',
                'created_at' => $campagne->created_at
            ];
        }
        
        // Salariés de la structure qui n'ont pas encore participé
        $salariesSansReponse = Salarie::where('structure_id', $structure->id)
            ->doesntHave('responses')
            ->count();
            
        if ($salariesSansReponse > 0) {
            $alertes[] = [
                'type' => 'warning', 
                'title' => 'Salariés non participants',
                'description' => $salariesSansReponse . ' salarié(s) de votre structure n\'ont pas encore participé aux évaluations',
                'created_at' => now()
            ];
        }
        
        return collect($alertes)->sortByDesc('created_at')->take(5)->values();
    }
}
