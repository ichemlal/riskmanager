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

        .stat-icon {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #8b44ff;
            margin-bottom: 8px;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            font-weight: 500;
        }

        .section-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: white;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .risk-distribution {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .risk-level {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
        }

        .risk-level-count {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .risk-level-label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            line-height: 1.2;
        }

        .risk-low .risk-level-count { color: #10b981; }
        .risk-medium .risk-level-count { color: #f59e0b; }
        .risk-high .risk-level-count { color: #ef4444; }
        .risk-major .risk-level-count { color: #dc2626; }
        .risk-critical .risk-level-count { color: #991b1b; }

        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .data-table th,
        .data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 13px;
        }

        .data-table th {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            background: rgba(255, 255, 255, 0.05);
        }

        .data-table td {
            color: rgba(255, 255, 255, 0.8);
        }

        .data-table tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            overflow: hidden;
            margin-top: 5px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
            transition: width 0.3s ease;
        }

        .criticality-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .criticality-faible { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .criticality-modéré { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
        .criticality-élevé { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .criticality-majeur { background: rgba(220, 38, 38, 0.2); color: #dc2626; }
        .criticality-critique { background: rgba(153, 27, 27, 0.2); color: #991b1b; }

        .alert-high-risk {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .alert-title {
            color: #ef4444;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-content {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-flex;
            align-items: center;
            gap: 6px;
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

        .btn-success {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .tab {
            padding: 10px 20px;
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .tab.active {
            color: #8b44ff;
            border-bottom-color: #8b44ff;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
            
            .action-buttons {
                flex-direction: column;
            }

            .tabs {
                overflow-x: auto;
                flex-wrap: nowrap;
            }
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Résultats de Campagne') }}
        </h2>
    </x-slot>

    <div class="results-container">
        <div class="results-header">
            <h1 class="results-title">{{ $campaign->nom }}</h1>
            <p class="results-subtitle">Tableau de bord des résultats globaux</p>
        </div>

        <!-- Global Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-value">{{ $globalStats['total_participants'] }}</div>
                <div class="stat-label">Participants Total</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-value">{{ $globalStats['responded_participants'] }}</div>
                <div class="stat-label">Ont Participé</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-value">{{ $globalStats['response_rate'] }}%</div>
                <div class="stat-label">Taux de Participation</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📝</div>
                <div class="stat-value">{{ $globalStats['total_questions'] }}</div>
                <div class="stat-label">Questions Total</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">💬</div>
                <div class="stat-value">{{ $globalStats['total_responses'] }}</div>
                <div class="stat-label">Réponses Total</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🎯</div>
                <div class="stat-value">{{ $globalStats['average_completion'] }}%</div>
                <div class="stat-label">Completion Moyenne</div>
            </div>
        </div>

        <!-- High Risk Alert -->
        @if($riskDistribution['critical'] > 0 || $riskDistribution['major'] > 0)
        <div class="alert-high-risk">
            <div class="alert-title">
                ⚠️ Attention: Risques Élevés Détectés
            </div>
            <div class="alert-content">
                {{ $riskDistribution['critical'] + $riskDistribution['major'] }} situation(s) à risque critique/majeur nécessitent une attention immédiate.
            </div>
        </div>
        @endif

        <!-- Risk Distribution -->
        <div class="section-card">
            <h3 class="section-title">
                📈 Répartition Globale des Risques
            </h3>
            <div class="risk-distribution">
                <div class="risk-level risk-low">
                    <div class="risk-level-count">{{ $riskDistribution['low'] }}</div>
                    <div class="risk-level-label">Risque<br>Faible<br>(1-5)</div>
                </div>
                <div class="risk-level risk-medium">
                    <div class="risk-level-count">{{ $riskDistribution['medium'] }}</div>
                    <div class="risk-level-label">Risque<br>Modéré<br>(6-10)</div>
                </div>
                <div class="risk-level risk-high">
                    <div class="risk-level-count">{{ $riskDistribution['high'] }}</div>
                    <div class="risk-level-label">Risque<br>Élevé<br>(11-15)</div>
                </div>
                <div class="risk-level risk-major">
                    <div class="risk-level-count">{{ $riskDistribution['major'] }}</div>
                    <div class="risk-level-label">Risque<br>Majeur<br>(16-20)</div>
                </div>
                <div class="risk-level risk-critical">
                    <div class="risk-level-count">{{ $riskDistribution['critical'] }}</div>
                    <div class="risk-level-label">Risque<br>Critique<br>(>20)</div>
                </div>
            </div>
        </div>

        <!-- Tabs for detailed views -->
        <div class="section-card">
            <div class="tabs">
                <button class="tab active" onclick="showTab('questions')">📋 Par Question</button>
                <button class="tab" onclick="showTab('participants')">👥 Par Participant</button>
            </div>

            <!-- Questions Analysis -->
            <div id="questions-tab" class="tab-content active">
                <h3 class="section-title">Analyse par Question</h3>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Catégorie</th>
                                <th>Réponses</th>
                                <th>Grav. Moy.</th>
                                <th>Fréq. Moy.</th>
                                <th>Crit. Moy.</th>
                                <th>Crit. Max</th>
                                <th>Distribution Risques</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questionStats as $stat)
                            <tr>
                                <td style="max-width: 250px;">{{ substr($stat['question'], 0, 80) }}{{ strlen($stat['question']) > 80 ? '...' : '' }}</td>
                                <td>{{ $stat['category'] ?? 'N/A' }}</td>
                                <td><strong>{{ $stat['response_count'] }}</strong></td>
                                <td>{{ $stat['average_gravity'] ?: 'N/A' }}</td>
                                <td>{{ $stat['average_frequency'] ?: 'N/A' }}</td>
                                <td>{{ $stat['average_criticality'] ?: 'N/A' }}</td>
                                <td>{{ $stat['max_criticality'] ?: 'N/A' }}</td>
                                <td>
                                    <div style="font-size: 11px;">
                                        <span style="color: #10b981;">F:{{ $stat['risk_distribution']['low'] }}</span>
                                        <span style="color: #f59e0b;">M:{{ $stat['risk_distribution']['medium'] }}</span>
                                        <span style="color: #ef4444;">E:{{ $stat['risk_distribution']['high'] }}</span>
                                        <span style="color: #dc2626;">Mj:{{ $stat['risk_distribution']['major'] }}</span>
                                        <span style="color: #991b1b;">C:{{ $stat['risk_distribution']['critical'] }}</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Participants Analysis -->
            <div id="participants-tab" class="tab-content">
                <h3 class="section-title">Analyse par Participant</h3>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Participant</th>
                                <th>Métier</th>
                                <th>Groupe</th>
                                <th>Réponses</th>
                                <th>Completion</th>
                                <th>Crit. Moy.</th>
                                <th>Crit. Max</th>
                                <th>Risques Élevés</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($participantStats as $participant)
                            <tr>
                                <td>{{ $participant['salarie']->nom ?? 'N/A' }} {{ $participant['salarie']->prenom ?? '' }}</td>
                                <td>{{ $participant['salarie']->metier->name ?? 'N/A' }}</td>
                                <td>{{ $participant['salarie']->groupes->first()->nom ?? 'N/A' }}</td>
                                <td><strong>{{ $participant['response_count'] }}</strong></td>
                                <td>
                                    <div>{{ $participant['completion_rate'] }}%</div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $participant['completion_rate'] }}%"></div>
                                    </div>
                                </td>
                                <td>{{ $participant['average_criticality'] ?: 'N/A' }}</td>
                                <td>{{ $participant['max_criticality'] ?: 'N/A' }}</td>
                                <td>
                                    @if($participant['high_risk_count'] > 0)
                                        <span style="color: #ef4444; font-weight: bold;">{{ $participant['high_risk_count'] }}</span>
                                    @else
                                        <span style="color: #10b981;">0</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('questions.campaigns') }}" class="btn btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Retour aux Campagnes
            </a>
            
            <button onclick="window.print()" class="btn btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6,9 6,2 18,2 18,9"/>
                    <path d="M6,18H4a2,2 0,0,1,-2,-2V11a2,2 0,0,1,2,-2H20a2,2 0,0,1,2,2v5a2,2 0,0,1,-2,2H18"/>
                    <polyline points="6,14 6,22 18,22 18,14"/>
                </svg>
                Imprimer
            </button>
            
            <a href="{{ route('questions.campaigns.results.export', $campaign->id) }}" class="btn btn-success">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14,2H6A2,2 0,0,0 4,4V20A2,2 0,0,0 6,22H18A2,2 0,0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                </svg>
                Exporter
            </a>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Add active class to clicked tab button
            event.target.classList.add('active');
        }
    </script>
</x-app-layout>
