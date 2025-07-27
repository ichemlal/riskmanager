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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 68, 255, 0.3);
        }

        .stat-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: #8b44ff;
            margin-bottom: 10px;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            font-weight: 500;
        }

        .chart-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .chart-title {
            font-size: 20px;
            font-weight: 600;
            color: white;
            margin-bottom: 20px;
            text-align: center;
        }

        .risk-levels {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .risk-level {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            min-width: 100px;
        }

        .risk-level-count {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .risk-level-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
        }

        .risk-low .risk-level-count { color: #10b981; }
        .risk-medium .risk-level-count { color: #f59e0b; }
        .risk-high .risk-level-count { color: #ef4444; }
        .risk-major .risk-level-count { color: #dc2626; }
        .risk-critical .risk-level-count { color: #991b1b; }

        .responses-table {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .table-title {
            font-size: 20px;
            font-weight: 600;
            color: white;
            margin-bottom: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .responses-list {
            width: 100%;
            border-collapse: collapse;
        }

        .responses-list th,
        .responses-list td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .responses-list th {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            background: rgba(255, 255, 255, 0.05);
            font-size: 14px;
        }

        .responses-list td {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .responses-list tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .criticality-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .criticality-faible {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .criticality-modéré {
            background: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
        }

        .criticality-élevé {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .criticality-majeur {
            background: rgba(220, 38, 38, 0.2);
            color: #dc2626;
        }

        .criticality-critique {
            background: rgba(153, 27, 27, 0.2);
            color: #991b1b;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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

        .progress-circle {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
        }

        .progress-ring {
            transform: rotate(-90deg);
        }

        .progress-ring-circle {
            transition: stroke-dashoffset 0.35s;
            transform-origin: 50% 50%;
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            font-weight: 700;
            color: #8b44ff;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .risk-levels {
                flex-direction: column;
            }
            
            .action-buttons {
                flex-direction: column;
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
            <h1 class="results-title">{{ $campaign->nom }}</h1>
            <p class="results-subtitle">Vos résultats personnels d'évaluation des risques</p>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-value">{{ $completionRate }}%</div>
                <div class="stat-label">Taux de Completion</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-value">{{ $answeredQuestions }}/{{ $totalQuestions }}</div>
                <div class="stat-label">Questions Répondues</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📈</div>
                <div class="stat-value">{{ number_format($averageCriticality, 1) }}</div>
                <div class="stat-label">Criticité Moyenne</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">⚠️</div>
                <div class="stat-value">{{ $maxCriticality }}</div>
                <div class="stat-label">Criticité Maximale</div>
            </div>
        </div>

        <!-- Risk Distribution Chart -->
        <div class="chart-container">
            <h3 class="chart-title">Répartition des Niveaux de Risque</h3>
            <div class="risk-levels">
                <div class="risk-level risk-low">
                    <div class="risk-level-count">{{ $riskStats['low'] }}</div>
                    <div class="risk-level-label">Risque<br>Faible<br>(1-5)</div>
                </div>
                <div class="risk-level risk-medium">
                    <div class="risk-level-count">{{ $riskStats['medium'] }}</div>
                    <div class="risk-level-label">Risque<br>Modéré<br>(6-10)</div>
                </div>
                <div class="risk-level risk-high">
                    <div class="risk-level-count">{{ $riskStats['high'] }}</div>
                    <div class="risk-level-label">Risque<br>Élevé<br>(11-15)</div>
                </div>
                <div class="risk-level risk-major">
                    <div class="risk-level-count">{{ $riskStats['major'] }}</div>
                    <div class="risk-level-label">Risque<br>Majeur<br>(16-20)</div>
                </div>
                <div class="risk-level risk-critical">
                    <div class="risk-level-count">{{ $riskStats['critical'] }}</div>
                    <div class="risk-level-label">Risque<br>Critique<br>(>20)</div>
                </div>
            </div>
        </div>

        <!-- Detailed Responses -->
        @if($detailedResponses->count() > 0)
        <div class="responses-table">
            <h3 class="table-title">Détail de vos Réponses</h3>
            <div class="table-responsive">
                <table class="responses-list">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Catégorie</th>
                            <th>Gravité</th>
                            <th>Fréquence</th>
                            <th>Criticité</th>
                            <th>Niveau</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detailedResponses as $response)
                        <tr>
                            <td style="max-width: 300px;">{{ substr($response['question'], 0, 100) }}{{ strlen($response['question']) > 100 ? '...' : '' }}</td>
                            <td>{{ $response['category'] ?? 'N/A' }}</td>
                            <td>{{ $response['gravity'] }}/5</td>
                            <td>{{ $response['frequency'] }}/5</td>
                            <td><strong>{{ $response['criticality'] }}</strong></td>
                            <td>
                                <span class="criticality-badge criticality-{{ strtolower($response['criticality_level']) }}">
                                    {{ $response['criticality_level'] }}
                                </span>
                            </td>
                            <td>{{ $response['created_at']->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('quiz') }}" class="btn btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Retour aux Campagnes
            </a>
            
            @if($completionRate < 100)
            <a href="{{ route('quiz') }}" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 12v8a2 2 0 002 2h12a2 2 0 002-2v-8"/>
                    <polyline points="16,6 12,2 8,6"/>
                    <line x1="12" y1="2" x2="12" y2="15"/>
                </svg>
                Continuer le Quiz
            </a>
            @endif
        </div>
    </div>
</x-app-layout>
