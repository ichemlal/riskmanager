<x-app-layout>
    <style>
        .results-container {
            max-width: 1200px;
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

        .campaigns-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .campaign-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .campaign-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
        }

        .campaign-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 68, 255, 0.3);
        }

        .campaign-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .campaign-title {
            font-size: 18px;
            font-weight: 600;
            color: white;
            margin-bottom: 5px;
        }

        .campaign-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.4);
        }

        .status-completed {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.4);
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.4);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 12px;
            text-align: center;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #8b44ff;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }

        .progress-section {
            margin-bottom: 20px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .progress-text {
            color: rgba(255, 255, 255, 0.7);
        }

        .progress-percentage {
            font-weight: 600;
            color: #8b44ff;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
            transition: width 0.3s ease;
        }

        .risk-indicators {
            display: flex;
            justify-content: space-around;
            margin: 15px 0;
        }

        .risk-indicator {
            text-align: center;
        }

        .risk-value {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .risk-label {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.6);
        }

        .risk-low { color: #10b981; }
        .risk-medium { color: #f59e0b; }
        .risk-high { color: #ef4444; }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            flex: 1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
            color: white;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(139, 68, 255, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(255, 255, 255, 0.6);
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            color: #f59e0b;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            color: #ef4444;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .campaigns-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mes Résultats') }}
        </h2>
    </x-slot>

    <div class="results-container">
        <div class="results-header">
            <h1 class="results-title">Mes Résultats DUERP</h1>
            <p class="results-subtitle">Consultez vos résultats d'évaluation des risques par campagne</p>
        </div>

        @if($campaignsWithResults->count() > 0)
            <div class="campaigns-grid">
                @foreach($campaignsWithResults as $campaign)
                    <div class="campaign-card">
                        <div class="campaign-header">
                            <div>
                                <h3 class="campaign-title">{{ $campaign->nom }}</h3>
                            </div>
                            <span class="campaign-status status-{{ strtolower($campaign->status) }}">
                                {{ ucfirst($campaign->status === 'completed' ? 'Terminé' : ($campaign->status === 'active' ? 'En cours' : 'En attente')) }}
                            </span>
                        </div>

                        <!-- Progress Section -->
                        <div class="progress-section">
                            <div class="progress-label">
                                <span class="progress-text">Progression</span>
                                <span class="progress-percentage">{{ $campaign->user_progress }}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $campaign->user_progress }}%"></div>
                            </div>
                        </div>

                        <!-- Statistics Grid -->
                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-value">{{ $campaign->answered_questions }}/{{ $campaign->total_questions }}</div>
                                <div class="stat-label">Questions Répondues</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $campaign->average_criticality }}</div>
                                <div class="stat-label">Criticité Moyenne</div>
                            </div>
                        </div>

                        <!-- Risk Indicators -->
                        @if($campaign->answered_questions > 0)
                            <div class="risk-indicators">
                                <div class="risk-indicator">
                                    <div class="risk-value risk-medium">{{ $campaign->max_criticality }}</div>
                                    <div class="risk-label">Criticité Max</div>
                                </div>
                                <div class="risk-indicator">
                                    <div class="risk-value risk-high">{{ $campaign->high_risk_count }}</div>
                                    <div class="risk-label">Risques Élevés</div>
                                </div>
                            </div>

                            <!-- Warnings -->
                            @if($campaign->high_risk_count > 0)
                                <div class="alert-danger">
                                    ⚠️ {{ $campaign->high_risk_count }} risque(s) élevé(s) identifié(s)
                                </div>
                            @elseif($campaign->user_progress < 100)
                                <div class="alert-warning">
                                    📝 Évaluation en cours - {{ 100 - $campaign->user_progress }}% restant
                                </div>
                            @endif
                        @endif

                        <!-- Actions -->
                        <div class="actions">
                            @if($campaign->is_completed)
                                <a href="{{ route('questions.campaigns.results', $campaign->id) }}" class="btn btn-primary">
                                    📊 Voir Détails
                                </a>
                                <a href="{{ route('quiz') }}" class="btn btn-secondary">
                                    📋 Autres Campagnes
                                </a>
                            @else
                                <a href="{{ route('quiz') }}" class="btn btn-primary">
                                    @if($campaign->user_progress > 0)
                                        🔄 Continuer
                                    @else
                                        ▶️ Commencer
                                    @endif
                                </a>
                                @if($campaign->answered_questions > 0)
                                    <a href="{{ route('questions.campaigns.results', $campaign->id) }}" class="btn btn-secondary">
                                        👁️ Aperçu
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📊</div>
                <h3>Aucune campagne assignée</h3>
                <p>Vous n'avez pas encore de campagnes d'évaluation des risques assignées.</p>
                <div style="margin-top: 20px;">
                    <a href="{{ route('quiz') }}" class="btn btn-primary">
                        🔍 Vérifier les campagnes
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
