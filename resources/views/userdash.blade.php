<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de Bord') }}
        </h2>
    </x-slot>
<div class="content-max">
        <div class="page-header">
            <h1>Mon Tableau de Bord</h1>
            <p>Suivez votre progression et gérez vos questionnaires DUERP</p>
        </div>

        <!-- User Progress Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon purple">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <div class="stat-change positive">
                        {{ $stats['campagnes_completes'] ?? 0 }}/{{ $stats['mes_campagnes'] ?? 0 }}
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['campagnes_completes'] ?? 0 }}</h3>
                    <p>Campagnes complétées</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon blue">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <div class="stat-change {{ $stats['taux_completion'] >= 80 ? 'positive' : ($stats['taux_completion'] >= 50 ? 'neutral' : 'negative') }}">
                        {{ $stats['taux_completion'] ?? 0 }}%
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['taux_completion'] ?? 0 }}%</h3>
                    <p>Taux de completion</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon green">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                    <div class="stat-change positive">
                        {{ $stats['mes_campagnes'] ?? 0 }} total
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['mes_campagnes'] ?? 0 }}</h3>
                    <p>Mes campagnes</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon red">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11H7v-2h10v2z"/>
                        </svg>
                    </div>
                    <div class="stat-change {{ $stats['mon_score_risque'] >= 16 ? 'negative' : ($stats['mon_score_risque'] >= 8 ? 'neutral' : 'positive') }}">
                        {{ $stats['mon_score_risque'] >= 16 ? 'Élevé' : ($stats['mon_score_risque'] >= 8 ? 'Moyen' : 'Faible') }}
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['mon_score_risque'] ?? 0 }}</h3>
                    <p>Score de risque moyen</p>
                </div>
            </div>
        </div>

        <!-- Active Campaigns & Questionnaires -->
        <div class="charts-grid">
            <!-- Questionnaires Assignés -->
            <div class="chart-card">
                <h3>Questionnaires Assignés</h3>
                <div class="questionnaires-list" style="max-height: 400px; overflow-y: auto;">
                    @forelse($assignedQuestionnaires ?? [] as $questionnaire)
                        <div class="questionnaire-item" style="display: flex; align-items: center; justify-content: space-between; padding: 15px; margin-bottom: 10px; background: rgba(255, 255, 255, 0.05); border-radius: 10px; border-left: 4px solid {{ $questionnaire->status === 'completed' ? '#4ade80' : ($questionnaire->is_overdue ? '#f87171' : '#8b44ff') }};">
                            <div style="flex: 1;">
                                <h4 style="color: white; font-size: 16px; font-weight: 600; margin-bottom: 5px;">
                                    {{ $questionnaire->campaign->title ?? 'Campagne sans titre' }}
                                </h4>
                                <p style="color: rgba(255, 255, 255, 0.7); font-size: 14px; margin-bottom: 5px;">
                                    {{ $questionnaire->questionnaire->title ?? 'Questionnaire' }}
                                </p>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="font-size: 12px; color: rgba(255, 255, 255, 0.6);">
                                        Échéance: {{ $questionnaire->due_date ? $questionnaire->due_date->format('d/m/Y') : 'Non définie' }}
                                    </span>
                                    @if($questionnaire->status === 'completed')
                                        <span style="background: rgba(34, 197, 94, 0.2); color: #4ade80; padding: 2px 8px; border-radius: 12px; font-size: 11px;">
                                            Complété
                                        </span>
                                    @elseif($questionnaire->is_overdue ?? false)
                                        <span style="background: rgba(239, 68, 68, 0.2); color: #f87171; padding: 2px 8px; border-radius: 12px; font-size: 11px;">
                                            En retard
                                        </span>
                                    @else
                                        <span style="background: rgba(139, 68, 255, 0.2); color: #be9eff; padding: 2px 8px; border-radius: 12px; font-size: 11px;">
                                            En cours
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                @if($questionnaire->status !== 'completed')
                                    <a href="{{ route('user.questionnaire.take', $questionnaire->id) }}" 
                                       style="background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%); color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 500; text-align: center; transition: all 0.3s ease;">
                                        {{ $questionnaire->progress > 0 ? 'Continuer' : 'Commencer' }}
                                    </a>
                                @endif
                                @if($questionnaire->progress > 0)
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="flex: 1; height: 6px; background: rgba(255, 255, 255, 0.1); border-radius: 3px; overflow: hidden;">
                                            <div style="height: 100%; background: linear-gradient(135deg, #8b44ff, #3b82f6); width: {{ $questionnaire->progress ?? 0 }}%; transition: width 0.3s ease;"></div>
                                        </div>
                                        <span style="font-size: 12px; color: rgba(255, 255, 255, 0.6);">
                                            {{ $questionnaire->progress ?? 0 }}%
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px; color: rgba(255, 255, 255, 0.6);">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="margin-bottom: 16px;">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            <p>Aucun questionnaire assigné pour le moment</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Progress Chart -->
            <div class="chart-card">
                <h3>Progression Mensuelle</h3>
                <div class="chart-container">
                    <canvas id="progressChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Notifications -->
        <div class="alerts-card">
            <h3>Activité Récente & Notifications</h3>
            <div class="alerts-list">
                @forelse($recentActivities ?? [] as $activity)
                    <div class="alert {{ $activity->type === 'success' ? 'success' : ($activity->type === 'warning' ? 'warning' : 'critical') }}">
                        <div class="alert-icon">
                            @if($activity->type === 'success')
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            @elseif($activity->type === 'warning')
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                                </svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">{{ $activity->title }}</div>
                            <div class="alert-description">
                                {{ $activity->description }}
                                <span style="font-size: 12px; color: rgba(255, 255, 255, 0.5); display: block; margin-top: 5px;">
                                    {{ $activity->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert success">
                        <div class="alert-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">Bienvenue sur votre tableau de bord</div>
                            <div class="alert-description">
                                Vous pourrez voir ici vos activités récentes et notifications importantes.
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Progress Chart
        const ctx = document.getElementById('progressChart').getContext('2d');
        const progressChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyLabels ?? ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun']) !!},
                data: {!! json_encode($monthlyData ?? [2, 5, 8, 12, 15, 18]) !!}
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)'
                        }
                    }
                }
            }
        });

        // Add hover effects to questionnaire items
        document.querySelectorAll('.questionnaire-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 8px 25px rgba(139, 68, 255, 0.3)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });

        // Add hover effects to action buttons
        document.querySelectorAll('a[href*="questionnaire"]').forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
                this.style.boxShadow = '0 5px 15px rgba(139, 68, 255, 0.4)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = 'none';
            });
        });
    </script>
    @endpush
</x-app-layout>