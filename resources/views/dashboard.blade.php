<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
            <div class="content-wrapper">
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Dashboard</h1>
                    <p>Vue d'ensemble de l'évaluation des risques professionnels</p>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon purple">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </div>
                            <div class="stat-change positive">{{ $stats['total_participants'] > 0 ? '+' . number_format(($stats['total_participants'] / max($stats['total_salaries'], 1)) * 100, 0) . '%' : '0%' }}</div>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $stats['total_participants'] ?? 0 }}</h3>
                            <p>Participants ({{ $stats['total_salaries'] ?? 0 }} salariés)</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon green">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="22,12 18,12 15,21 9,3 6,12 2,12"/>
                                </svg>
                            </div>
                            <div class="stat-change {{ $stats['taux_participation'] >= 80 ? 'positive' : ($stats['taux_participation'] >= 50 ? 'neutral' : 'negative') }}">
                                {{ $stats['taux_participation'] >= 80 ? '+' : '' }}{{ $stats['taux_participation'] ?? 0 }}%
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $stats['taux_participation'] ?? 0 }}%</h3>
                            <p>Taux de participation</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon blue">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect width="20" height="14" x="2" y="3" rx="2" ry="2"/>
                                    <line x1="8" x2="16" y1="21" y2="21"/>
                                    <line x1="12" x2="12" y1="17" y2="21"/>
                                </svg>
                            </div>
                            <div class="stat-change positive">{{ $stats['metiers_analyses'] > 0 ? '+' . $stats['metiers_analyses'] : '0' }}</div>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $stats['metiers_analyses'] ?? 0 }}</h3>
                            <p>Métiers analysés</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon red">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                    <line x1="12" x2="12" y1="9" y2="13"/>
                                    <line x1="12" x2="12.01" y1="17" y2="17"/>
                                </svg>
                            </div>
                            <div class="stat-change {{ $stats['risques_critiques'] == 0 ? 'positive' : 'negative' }}">
                                {{ $stats['risques_critiques'] == 0 ? '✓' : $stats['risques_critiques'] }}
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $stats['risques_critiques'] ?? 0 }}</h3>
                            <p>Risques critiques</p>
                        </div>
                    </div>
                </div>

                <!-- Charts Grid -->
                <div class="charts-grid">
                    <div class="chart-card">
                        <h3>Participation par campagne</h3>
                        <div class="chart-container">
                            @if($stats['repartition_metiers']->count() > 0)
                                <div style="padding: 20px;">
                                    @foreach($stats['repartition_metiers'] as $item)
                                        <div style="margin-bottom: 15px;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                                <span style="color: rgba(255,255,255,0.9); font-weight: 500;">{{ $item->campagne }}</span>
                                                <span style="color: rgba(255,255,255,0.7); font-size: 14px;">{{ $item->total_responses }} réponses</span>
                                            </div>
                                            <div style="width: 100%; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; overflow: hidden;">
                                                <div style="height: 100%; background: linear-gradient(135deg, #667eea, #764ba2); width: {{ min(100, ($item->total_responses / $stats['repartition_metiers']->max('total_responses')) * 100) }}%; border-radius: 4px;"></div>
                                            </div>
                                            <div style="margin-top: 5px; font-size: 12px; color: rgba(255,255,255,0.6);">
                                                Score de risque moyen: {{ number_format($item->risk_score, 1) }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 200px; color: rgba(255,255,255,0.6);">
                                    <div style="text-align: center;">
                                        <p>📊</p>
                                        <p>Aucune donnée disponible</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="chart-card">
                        <h3>Répartition des risques</h3>
                        <div class="chart-container">
                            @php
                                $totalResponses = \App\Models\Response::whereHas('campagne', function($query) {
                                    $query->where('user_id', auth()->user()->id);
                                })->count();
                                
                                $faibleRisque = \App\Models\Response::whereHas('campagne', function($query) {
                                    $query->where('user_id', auth()->user()->id);
                                })->whereRaw('gravity * frequency < 8')->count();
                                
                                $moyenRisque = \App\Models\Response::whereHas('campagne', function($query) {
                                    $query->where('user_id', auth()->user()->id);
                                })->whereRaw('gravity * frequency >= 8 AND gravity * frequency < 16')->count();
                                
                                $hautRisque = \App\Models\Response::whereHas('campagne', function($query) {
                                    $query->where('user_id', auth()->user()->id);
                                })->whereRaw('gravity * frequency >= 16')->count();
                            @endphp
                            
                            @if($totalResponses > 0)
                                <div style="padding: 20px;">
                                    <div style="margin-bottom: 20px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                            <span style="color: #22c55e; font-weight: 500;">🟢 Risque Faible</span>
                                            <span style="color: rgba(255,255,255,0.7);">{{ $faibleRisque }} ({{ $totalResponses > 0 ? number_format(($faibleRisque/$totalResponses)*100, 1) : 0 }}%)</span>
                                        </div>
                                        <div style="width: 100%; height: 10px; background: rgba(255,255,255,0.1); border-radius: 5px;">
                                            <div style="height: 100%; background: linear-gradient(135deg, #22c55e, #16a34a); width: {{ $totalResponses > 0 ? ($faibleRisque/$totalResponses)*100 : 0 }}%; border-radius: 5px;"></div>
                                        </div>
                                    </div>
                                    
                                    <div style="margin-bottom: 20px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                            <span style="color: #f59e0b; font-weight: 500;">🟡 Risque Moyen</span>
                                            <span style="color: rgba(255,255,255,0.7);">{{ $moyenRisque }} ({{ $totalResponses > 0 ? number_format(($moyenRisque/$totalResponses)*100, 1) : 0 }}%)</span>
                                        </div>
                                        <div style="width: 100%; height: 10px; background: rgba(255,255,255,0.1); border-radius: 5px;">
                                            <div style="height: 100%; background: linear-gradient(135deg, #f59e0b, #d97706); width: {{ $totalResponses > 0 ? ($moyenRisque/$totalResponses)*100 : 0 }}%; border-radius: 5px;"></div>
                                        </div>
                                    </div>
                                    
                                    <div style="margin-bottom: 20px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                            <span style="color: #ef4444; font-weight: 500;">🔴 Risque Élevé</span>
                                            <span style="color: rgba(255,255,255,0.7);">{{ $hautRisque }} ({{ $totalResponses > 0 ? number_format(($hautRisque/$totalResponses)*100, 1) : 0 }}%)</span>
                                        </div>
                                        <div style="width: 100%; height: 10px; background: rgba(255,255,255,0.1); border-radius: 5px;">
                                            <div style="height: 100%; background: linear-gradient(135deg, #ef4444, #dc2626); width: {{ $totalResponses > 0 ? ($hautRisque/$totalResponses)*100 : 0 }}%; border-radius: 5px;"></div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 200px; color: rgba(255,255,255,0.6);">
                                    <div style="text-align: center;">
                                        <p>⚠️</p>
                                        <p>Aucune évaluation disponible</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Alerts -->
                <div class="alerts-card">
                    <h3>Alertes récentes</h3>
                    <div class="alerts-list">
                        @if($stats['alertes']->count() > 0)
                            @foreach($stats['alertes'] as $alerte)
                                <div class="alert {{ $alerte['type'] }}">
                                    <div class="alert-icon">
                                        @if($alerte['type'] == 'critical')
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                                <line x1="12" x2="12" y1="9" y2="13"/>
                                                <line x1="12" x2="12.01" y1="17" y2="17"/>
                                            </svg>
                                        @elseif($alerte['type'] == 'warning')
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                                <line x1="12" x2="12" y1="9" y2="13"/>
                                                <line x1="12" x2="12.01" y1="17" y2="17"/>
                                            </svg>
                                        @else
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="20,6 9,17 4,12"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="alert-content">
                                        <div class="alert-title">{{ $alerte['title'] }}</div>
                                        <div class="alert-description">{{ $alerte['description'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Alertes par défaut si aucune donnée -->
                            <div class="alert success">
                                <div class="alert-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="20,6 9,17 4,12"/>
                                    </svg>
                                </div>
                                <div class="alert-content">
                                    <div class="alert-title">Système opérationnel</div>
                                    <div class="alert-description">Aucune alerte critique détectée pour le moment</div>
                                </div>
                            </div>

                            <div class="alert warning">
                                <div class="alert-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                        <line x1="12" x2="12" y1="9" y2="13"/>
                                        <line x1="12" x2="12.01" y1="17" y2="17"/>
                                    </svg>
                                </div>
                                <div class="alert-content">
                                    <div class="alert-title">Début d'évaluation</div>
                                    <div class="alert-description">Commencez par créer des campagnes d'évaluation pour vos salariés</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        
</x-app-layout>
