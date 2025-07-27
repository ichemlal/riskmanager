<x-app-layout>
    <style>
        .results-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .results-header {
            background: linear-gradient(135deg, rgba(139, 68, 255, 0.1), rgba(59, 130, 246, 0.1));
            border: 1px solid rgba(139, 68, 255, 0.2);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        .results-title {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
        }

        .results-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 68, 255, 0.3);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin-bottom: 5px;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            font-weight: 500;
        }

        .campaigns-section {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .campaigns-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .campaign-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .campaign-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(139, 68, 255, 0.2);
            border-color: rgba(139, 68, 255, 0.4);
        }

        .campaign-header {
            display: flex;
            justify-content: between;
            align-items: start;
            margin-bottom: 15px;
        }

        .campaign-name {
            font-size: 18px;
            font-weight: 600;
            color: white;
            margin-bottom: 5px;
        }

        .campaign-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .campaign-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }

        .campaign-stat {
            text-align: center;
        }

        .campaign-stat-value {
            font-size: 20px;
            font-weight: 600;
            color: #60a5fa;
        }

        .campaign-stat-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        .risk-distribution {
            display: flex;
            gap: 5px;
            margin-bottom: 10px;
        }

        .risk-bar {
            height: 8px;
            border-radius: 4px;
            flex: 1;
        }

        .risk-low { background: #10b981; }
        .risk-medium { background: #f59e0b; }
        .risk-high { background: #f97316; }
        .risk-major { background: #ef4444; }
        .risk-critical { background: #dc2626; }

        .campaign-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-view {
            flex: 1;
            background: rgba(139, 68, 255, 0.2);
            border: 1px solid rgba(139, 68, 255, 0.4);
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-view:hover {
            background: rgba(139, 68, 255, 0.3);
            border-color: rgba(139, 68, 255, 0.6);
            text-decoration: none;
            color: white;
        }

        .global-risk-chart {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 30px;
        }

        .risk-legend {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .risk-legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .risk-legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }

        .risk-legend-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .risk-legend-count {
            color: white;
            font-weight: 600;
            margin-left: auto;
        }

        .completion-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .completion-high { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .completion-medium { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
        .completion-low { background: rgba(239, 68, 68, 0.2); color: #ef4444; }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(255, 255, 255, 0.6);
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
    </style>

    <div class="results-container">
        <!-- Header -->
        <div class="results-header">
            <h1 class="results-title">Vue d'ensemble des résultats</h1>
            <p class="results-subtitle">Analyse globale des campagnes d'évaluation - {{ $structure->name }}</p>
        </div>

        <!-- Global Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $globalStats['totalCampaigns'] }}</div>
                <div class="stat-label">Campagnes totales</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $globalStats['totalParticipants'] }}</div>
                <div class="stat-label">Participants</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $globalStats['totalResponses'] }}</div>
                <div class="stat-label">Réponses totales</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $globalStats['averageCompletionRate'] }}%</div>
                <div class="stat-label">Taux de complétion moyen</div>
            </div>
        </div>

        <!-- Global Risk Distribution -->
        <div class="global-risk-chart">
            <h2 class="section-title">
                📊 Distribution globale des risques
            </h2>
            <div class="risk-distribution">
                @php
                    $totalRisks = array_sum($globalStats['riskDistribution']);
                @endphp
                @foreach(['low', 'medium', 'high', 'major', 'critical'] as $level)
                    @php
                        $count = $globalStats['riskDistribution'][$level];
                        $width = $totalRisks > 0 ? ($count / $totalRisks) * 100 : 0;
                    @endphp
                    <div class="risk-bar risk-{{ $level }}" style="width: {{ $width }}%"></div>
                @endforeach
            </div>
            <div class="risk-legend">
                <div class="risk-legend-item">
                    <div class="risk-legend-color risk-low"></div>
                    <span class="risk-legend-text">Risque faible</span>
                    <span class="risk-legend-count">{{ $globalStats['riskDistribution']['low'] }}</span>
                </div>
                <div class="risk-legend-item">
                    <div class="risk-legend-color risk-medium"></div>
                    <span class="risk-legend-text">Risque modéré</span>
                    <span class="risk-legend-count">{{ $globalStats['riskDistribution']['medium'] }}</span>
                </div>
                <div class="risk-legend-item">
                    <div class="risk-legend-color risk-high"></div>
                    <span class="risk-legend-text">Risque élevé</span>
                    <span class="risk-legend-count">{{ $globalStats['riskDistribution']['high'] }}</span>
                </div>
                <div class="risk-legend-item">
                    <div class="risk-legend-color risk-major"></div>
                    <span class="risk-legend-text">Risque majeur</span>
                    <span class="risk-legend-count">{{ $globalStats['riskDistribution']['major'] }}</span>
                </div>
                <div class="risk-legend-item">
                    <div class="risk-legend-color risk-critical"></div>
                    <span class="risk-legend-text">Risque critique</span>
                    <span class="risk-legend-count">{{ $globalStats['riskDistribution']['critical'] }}</span>
                </div>
            </div>
        </div>

        <!-- Campaigns List -->
        <div class="campaigns-section">
            <h2 class="section-title">
                📋 Détails par campagne
            </h2>
            
            @if(count($campaignStats) > 0)
                <div class="campaigns-grid">
                    @foreach($campaignStats as $campaign)
                        <div class="campaign-card" onclick="window.location.href='{{ route('questions.campaigns.results', $campaign['id']) }}'">
                            <div class="campaign-header">
                                <div style="flex: 1;">
                                    <h3 class="campaign-name">{{ $campaign['name'] }}</h3>
                                    @if($campaign['description'])
                                        <p class="campaign-description">{{ $campaign['description'] }}</p>
                                    @endif
                                </div>
                                <div style="margin-left: 10px;">
                                    @php
                                        $completionClass = $campaign['completionRate'] >= 80 ? 'completion-high' : 
                                                          ($campaign['completionRate'] >= 50 ? 'completion-medium' : 'completion-low');
                                    @endphp
                                    <span class="completion-badge {{ $completionClass }}">
                                        {{ $campaign['completionRate'] }}% complété
                                    </span>
                                </div>
                            </div>

                            <div class="campaign-stats">
                                <div class="campaign-stat">
                                    <div class="campaign-stat-value">{{ $campaign['participants'] }}</div>
                                    <div class="campaign-stat-label">Participants</div>
                                </div>
                                <div class="campaign-stat">
                                    <div class="campaign-stat-value">{{ $campaign['totalResponses'] }}</div>
                                    <div class="campaign-stat-label">Réponses</div>
                                </div>
                                <div class="campaign-stat">
                                    <div class="campaign-stat-value">{{ $campaign['averageCriticality'] }}</div>
                                    <div class="campaign-stat-label">Criticité moy.</div>
                                </div>
                                <div class="campaign-stat">
                                    <div class="campaign-stat-value">{{ $campaign['maxCriticality'] }}</div>
                                    <div class="campaign-stat-label">Criticité max</div>
                                </div>
                            </div>

                            <div class="risk-distribution">
                                @php
                                    $totalCampaignRisks = array_sum($campaign['riskStats']);
                                @endphp
                                @foreach(['low', 'medium', 'high', 'major', 'critical'] as $level)
                                    @php
                                        $count = $campaign['riskStats'][$level];
                                        $width = $totalCampaignRisks > 0 ? ($count / $totalCampaignRisks) * 100 : 20;
                                    @endphp
                                    <div class="risk-bar risk-{{ $level }}" 
                                         style="width: {{ $width }}%" 
                                         title="{{ ucfirst($level) }}: {{ $count }}"></div>
                                @endforeach
                            </div>

                            <div class="campaign-actions">
                                <a href="{{ route('questions.campaigns.results', $campaign['id']) }}" class="btn-view">
                                    Voir les détails
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📊</div>
                    <h3 style="color: white; margin-bottom: 10px;">Aucune campagne avec résultats</h3>
                    <p>Il n'y a actuellement aucune campagne avec des résultats disponibles pour votre structure.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
