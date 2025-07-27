<x-app-layout>
    <style>
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
            font-size: 20px;
            font-weight: 600;
            color: white;
            margin-bottom: 5px;
        }

        .campaign-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
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

        .campaign-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .campaign-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
        }

        .meta-item {
            text-align: center;
        }

        .meta-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 5px;
        }

        .meta-value {
            font-size: 16px;
            font-weight: 600;
            color: white;
        }

        .campaign-progress {
            margin-bottom: 20px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .progress-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
        }

        .progress-percentage {
            font-size: 14px;
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

        .campaign-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
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

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(139, 68, 255, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn:disabled:hover {
            transform: none;
            box-shadow: none;
        }

        /* Quiz Modal */
        .quiz-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .quiz-modal.active {
            display: flex;
        }

        .quiz-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 30px;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }

        .quiz-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .quiz-title {
            font-size: 24px;
            font-weight: 700;
            color: white;
        }

        .quiz-close {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .quiz-close:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        .quiz-progress {
            margin-bottom: 30px;
        }

        .quiz-progress-text {
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 10px;
        }

        /* Progress Indicators */
        .progress-indicators {
            flex-wrap: wrap;
        }

        .progress-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .progress-indicator.current {
            background: #8b44ff;
            transform: scale(1.3);
            box-shadow: 0 0 10px rgba(139, 68, 255, 0.5);
        }

        .progress-indicator.completed {
            background: #10b981;
        }

        .progress-indicator.incomplete {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .progress-indicator:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            white-space: nowrap;
            z-index: 1000;
        }

        .question-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .question-text {
            font-size: 18px;
            font-weight: 600;
            color: white;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .question-options {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .option {
            display: flex;
            align-items: center;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid transparent;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .option:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(139, 68, 255, 0.5);
        }

        .option.selected {
            background: rgba(139, 68, 255, 0.2);
            border-color: #8b44ff;
        }

        .option input[type="radio"] {
            margin-right: 12px;
            accent-color: #8b44ff;
        }

        .option-text {
            color: white;
            font-size: 16px;
        }

        /* Gravity-Frequency Rating System */
        .gravity-frequency-container {
            gap: 30px;
        }

        .rating-section {
            background: rgba(255, 255, 255, 0.03);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .rating-scale {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .rating-option {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid transparent;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .rating-option:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(139, 68, 255, 0.5);
        }

        .rating-option.selected {
            background: rgba(139, 68, 255, 0.2);
            border-color: #8b44ff;
            box-shadow: 0 0 10px rgba(139, 68, 255, 0.3);
        }

        .rating-number {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .rating-option.selected .rating-number {
            background: linear-gradient(135deg, #a855f7 0%, #3b82f6 100%);
            transform: scale(1.1);
        }

        .rating-label {
            color: white;
            font-size: 14px;
            font-weight: 500;
        }

        .criticality-display {
            border: 2px solid rgba(139, 68, 255, 0.3);
        }

        .criticality-value {
            text-shadow: 0 0 10px rgba(139, 68, 255, 0.5);
        }

        /* Responsive adjustments for rating system */
        @media (max-width: 768px) {
            .gravity-frequency-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .rating-section {
                padding: 15px;
            }
            
            .rating-option {
                padding: 10px 12px;
            }
            
            .rating-number {
                width: 25px;
                height: 25px;
                margin-right: 10px;
            }
            
            .rating-label {
                font-size: 13px;
            }
        }

        .quiz-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .quiz-results {
            text-align: center;
            padding: 30px;
        }

        .results-score {
            font-size: 48px;
            font-weight: 700;
            color: #8b44ff;
            margin-bottom: 10px;
        }

        .results-text {
            font-size: 18px;
            color: white;
            margin-bottom: 20px;
        }

        .results-details {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 30px;
        }

        /* Answers Review Styles */
        .answers-review {
            max-height: 300px;
            overflow-y: auto;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
        }

        .review-question {
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            border-left: 4px solid transparent;
        }

        .review-question.high-risk {
            border-left-color: #ef4444;
        }

        .review-question.medium-risk {
            border-left-color: #f59e0b;
        }

        .review-question.low-risk {
            border-left-color: #10b981;
        }

        .review-question-text {
            font-size: 14px;
            font-weight: 600;
            color: white;
            margin-bottom: 10px;
        }

        .review-answer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.8);
        }

        .review-criticality {
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .criticality-low { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .criticality-medium { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
        .criticality-high { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .criticality-critical { background: rgba(147, 51, 234, 0.2); color: #a855f7; }

        /* Empty State */
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

        .empty-state h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: white;
        }

        .empty-state p {
            font-size: 16px;
        }

        /* Responsive Design */
        @media (min-width: 768px) {
            .main-content {
                padding: 30px;
            }
            
            .page-header h1 {
                font-size: 3rem;
            }
        }

        @media (min-width: 1024px) {
            .sidebar {
                position: static;
                transform: translateX(0);
                width: 280px;
                flex-shrink: 0;
            }
            
            .hamburger {
                display: none;
            }
            
            .overlay {
                display: none !important;
            }
            
            .main-content {
                padding: 40px;
            }
        }

        @media (min-width: 1440px) {
            .main-content {
                padding: 50px;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #8b44ff, #3b82f6);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #7c22f7, #2563eb);
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Parametrage') }}
        </h2>
    </x-slot>
 <div class="page-header">
                    <h1>Mes Campagnes</h1>
                    <p>Consultez vos campagnes assignées et participez aux évaluations DUERP</p>
                </div>

                @if(isset($campaigns) && count($campaigns) > 0)
                    <div class="campaigns-grid">
                        @foreach($campaigns as $campaign)
                            <div class="campaign-card">
                                <div class="campaign-header">
                                    <div>
                                        <h3 class="campaign-title">{{ $campaign->title ?? 'Campagne Sans Titre' }}</h3>
                                    </div>
                                    <span class="campaign-status status-{{ strtolower($campaign->status ?? 'pending') }}">
                                        {{ ucfirst($campaign->status ?? 'En attente') }}
                                    </span>
                                </div>

                                <p class="campaign-description">
                                    {{ $campaign->description ?? 'Aucune description disponible pour cette campagne.' }}
                                </p>

                                <div class="campaign-meta">
                                    <div class="meta-item">
                                        <div class="meta-label">Questions</div>
                                        <div class="meta-value">{{ isset($campaign->questions) ? count($campaign->questions) : 0 }}</div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label">Durée Estimée</div>
                                        <div class="meta-value">{{ $campaign->estimated_duration ?? '5' }} min</div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label">Date Limite</div>
                                        <div class="meta-value">
                                            {{ isset($campaign->deadline) ? \Carbon\Carbon::parse($campaign->deadline)->format('d/m/Y') : 'N/A' }}
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $userProgress = isset($campaign->user_progress) ? $campaign->user_progress : 0;
                                    $isCompleted = isset($campaign->completed_at) && $campaign->completed_at;
                                @endphp

                                <div class="campaign-progress">
                                    <div class="progress-label">
                                        <span class="progress-text">Progression</span>
                                        <span class="progress-percentage">{{ $userProgress }}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $userProgress }}%"></div>
                                    </div>
                                </div>

                                <div class="campaign-actions">
                                    @if($isCompleted)
                                        <button class="btn btn-secondary" disabled>
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 8px;">
                                                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            Terminé
                                        </button>
                                        <button class="btn btn-secondary" onclick="viewResults({{ $campaign->id ?? 0 }})">
                                            Voir Résultats
                                        </button>
                                    @else
                                        <button class="btn btn-primary" onclick="startQuiz({{ json_encode($campaign) }})">
                                            @if($userProgress > 0)
                                                Continuer
                                            @else
                                                Commencer
                                            @endif
                                        </button>
                                        @if(isset($campaign->preview_available) && $campaign->preview_available)
                                            <button class="btn btn-secondary" onclick="previewCampaign({{ $campaign->id ?? 0 }})">
                                                Aperçu
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div id="quizModal" class="quiz-modal">
        <div class="quiz-container">
            <div class="quiz-header">
                <h2 id="quizTitle" class="quiz-title">Quiz</h2>
                <button class="quiz-close" onclick="closeQuiz()">&times;</button>
            </div>

            <div id="quizProgress" class="quiz-progress">
                <div class="quiz-progress-text">
                    Question <span id="currentQuestion">1</span> sur <span id="totalQuestions">10</span>
                    <span id="completionStatus" style="margin-left: 15px; font-size: 12px; color: rgba(255, 255, 255, 0.6);"></span>
                </div>
                <div class="progress-bar">
                    <div id="quizProgressFill" class="progress-fill" style="width: 10%"></div>
                </div>
                
                <!-- Indicateur de progression par question -->
                <div id="progressIndicators" class="progress-indicators" style="display: flex; justify-content: center; gap: 5px; margin-top: 15px;">
                    <!-- Les indicateurs seront générés dynamiquement -->
                </div>
            </div>

            <div id="quizContent">
                <!-- Quiz questions will be loaded here -->
            </div>

            <div id="quizResults" class="quiz-results" style="display: none;">
                <div id="resultsScore" class="results-score">85%</div>
                <div class="results-text">Aperçu de vos réponses</div>
                <div id="resultsDetails" class="results-details">
                    Vous avez répondu à <span id="correctAnswers">8</span> questions sur <span id="totalAnswers">10</span>.
                </div>
                
                <!-- Résumé des réponses par question -->
                <div id="answersReview" class="answers-review" style="margin: 25px 0; text-align: left;">
                    <!-- Le résumé sera généré ici -->
                </div>
                
                <div class="results-actions" style="display: flex; gap: 15px; justify-content: center; margin-top: 25px;">
                    <button class="btn btn-secondary" onclick="reviewAnswers()">Modifier les Réponses</button>
                    <button class="btn btn-primary" onclick="submitQuiz()">Valider Définitivement</button>
                </div>
            </div>

            <div id="quizNavigation" class="quiz-navigation">
                <button id="prevBtn" class="btn btn-secondary" onclick="previousQuestion()" disabled>Précédent</button>
                <button id="nextBtn" class="btn btn-primary" onclick="nextQuestion()">Suivant</button>
            </div>
        </div>
    </div>

    <script>
        let currentCampaign = null;
        let currentQuestionIndex = 0;
        let userAnswers = {};
        let quizQuestions = [];

        function startQuiz(campaign) {
            currentCampaign = campaign;
            currentQuestionIndex = 0;
            userAnswers = {};
            
            // Check if campaign has questions
            if (!campaign.questions || campaign.questions.length === 0) {
                alert('Cette campagne ne contient aucune question. Contactez votre administrateur.');
                return;
            }
            
            quizQuestions = campaign.questions;
            
            document.getElementById('quizTitle').textContent = campaign.title || 'Quiz';
            document.getElementById('totalQuestions').textContent = quizQuestions.length;
            document.getElementById('quizModal').classList.add('active');
            
            // Initialize progress indicators
            updateProgressIndicators();
            
            loadQuestion();
        }

        function loadQuestion() {
            if (currentQuestionIndex >= quizQuestions.length) {
                showResults();
                return;
            }

            const question = quizQuestions[currentQuestionIndex];
            document.getElementById('currentQuestion').textContent = currentQuestionIndex + 1;

            const progressPercent = ((currentQuestionIndex + 1) / quizQuestions.length) * 100;
            document.getElementById('quizProgressFill').style.width = progressPercent + '%';

            // Update completion status
            const answeredCount = Object.keys(userAnswers).filter(key => 
                userAnswers[key] && userAnswers[key].gravity && userAnswers[key].frequency
            ).length;
            document.getElementById('completionStatus').textContent = `(${answeredCount} répondues)`;

            // Update progress indicators
            updateProgressIndicators();

            // Get current answers for this question
            const currentAnswer = userAnswers[currentQuestionIndex] || { gravity: null, frequency: null };

            const quizContent = document.getElementById('quizContent');
            quizContent.innerHTML = `
                <div class="question-card">
                    <div class="question-text">${question.question || 'Question non disponible'}</div>
                    
                    ${question.help ? `<div style="background: rgba(59, 130, 246, 0.1); padding: 15px; border-radius: 8px; margin: 15px 0; color: rgba(255, 255, 255, 0.8); font-size: 14px;">
                        <strong>Aide :</strong> ${question.help}
                    </div>` : ''}
                    
                    ${question.examples ? `<div style="background: rgba(34, 197, 94, 0.1); padding: 15px; border-radius: 8px; margin: 15px 0; color: rgba(255, 255, 255, 0.8); font-size: 14px;">
                        <strong>Exemples :</strong> ${question.examples}
                    </div>` : ''}
                    
                    <div class="gravity-frequency-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 25px;">
                        
                        <!-- Gravité -->
                        <div class="rating-section">
                            <h4 style="color: white; font-size: 18px; margin-bottom: 15px; text-align: center;">
                                🎯 Gravité du Risque
                            </h4>
                            <p style="color: rgba(255, 255, 255, 0.7); font-size: 12px; text-align: center; margin-bottom: 20px;">
                                Si ce risque se concrétise, quelle serait la gravité des conséquences ?
                            </p>
                            <div class="rating-scale">
                                ${[1, 2, 3, 4, 5].map(value => `
                                    <div class="rating-option ${currentAnswer.gravity === value ? 'selected' : ''}" 
                                         onclick="setGravity(${currentQuestionIndex}, ${value})">
                                        <div class="rating-number">${value}</div>
                                        <div class="rating-label">${getGravityLabel(value)}</div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        
                        <!-- Fréquence -->
                        <div class="rating-section">
                            <h4 style="color: white; font-size: 18px; margin-bottom: 15px; text-align: center;">
                                📊 Fréquence du Risque
                            </h4>
                            <p style="color: rgba(255, 255, 255, 0.7); font-size: 12px; text-align: center; margin-bottom: 20px;">
                                Quelle est la probabilité que ce risque se produise ?
                            </p>
                            <div class="rating-scale">
                                ${[1, 2, 3, 4, 5].map(value => `
                                    <div class="rating-option ${currentAnswer.frequency === value ? 'selected' : ''}" 
                                         onclick="setFrequency(${currentQuestionIndex}, ${value})">
                                        <div class="rating-number">${value}</div>
                                        <div class="rating-label">${getFrequencyLabel(value)}</div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Criticité calculée -->
                    <div id="criticalityDisplay_${currentQuestionIndex}" class="criticality-display" style="margin-top: 25px; padding: 20px; background: rgba(139, 68, 255, 0.1); border-radius: 12px; text-align: center; display: ${currentAnswer.gravity && currentAnswer.frequency ? 'block' : 'none'};">
                        <h4 style="color: #8b44ff; margin-bottom: 10px;">Niveau de Criticité</h4>
                        <div class="criticality-value" style="font-size: 24px; font-weight: bold; color: white;">
                            ${currentAnswer.gravity && currentAnswer.frequency ? (currentAnswer.gravity * currentAnswer.frequency) : 0}
                        </div>
                        <div class="criticality-level" style="color: rgba(255, 255, 255, 0.7);">
                            ${getCriticalityLevel(currentAnswer.gravity * currentAnswer.frequency)}
                        </div>
                    </div>
                </div>
            `;

            // Update navigation buttons
            document.getElementById('prevBtn').disabled = currentQuestionIndex === 0;
            document.getElementById('nextBtn').textContent = currentQuestionIndex === quizQuestions.length - 1 ? 'Terminer' : 'Suivant';

            document.getElementById('quizResults').style.display = 'none';
            document.getElementById('quizContent').style.display = 'block';
            document.getElementById('quizNavigation').style.display = 'flex';
        }

        function setGravity(questionIndex, value) {
            if (!userAnswers[questionIndex]) {
                userAnswers[questionIndex] = { gravity: null, frequency: null };
            }
            userAnswers[questionIndex].gravity = value;
            
            // Update UI
            document.querySelectorAll('.rating-section:first-child .rating-option').forEach((option, index) => {
                option.classList.toggle('selected', index + 1 === value);
            });
            
            updateCriticality(questionIndex);
            updateProgressIndicators(); // Refresh progress indicators
        }

        function setFrequency(questionIndex, value) {
            if (!userAnswers[questionIndex]) {
                userAnswers[questionIndex] = { gravity: null, frequency: null };
            }
            userAnswers[questionIndex].frequency = value;
            
            // Update UI
            document.querySelectorAll('.rating-section:last-child .rating-option').forEach((option, index) => {
                option.classList.toggle('selected', index + 1 === value);
            });
            
            updateCriticality(questionIndex);
            updateProgressIndicators(); // Refresh progress indicators
        }

        function updateProgressIndicators() {
            const container = document.getElementById('progressIndicators');
            if (!container) return;

            let indicatorsHTML = '';
            for (let i = 0; i < quizQuestions.length; i++) {
                const isAnswered = userAnswers[i] && userAnswers[i].gravity && userAnswers[i].frequency;
                const isCurrent = i === currentQuestionIndex;
                
                let className = 'progress-indicator';
                if (isCurrent) className += ' current';
                else if (isAnswered) className += ' completed';
                else className += ' incomplete';
                
                const tooltip = `Question ${i + 1}${isAnswered ? ' - Répondue' : ' - Non répondue'}`;
                
                indicatorsHTML += `<div class="${className}" onclick="goToQuestion(${i})" data-tooltip="${tooltip}"></div>`;
            }
            
            container.innerHTML = indicatorsHTML;
        }

        function goToQuestion(questionIndex) {
            if (questionIndex >= 0 && questionIndex < quizQuestions.length) {
                currentQuestionIndex = questionIndex;
                loadQuestion();
            }
        }

        function updateCriticality(questionIndex) {
            const answer = userAnswers[questionIndex];
            if (answer && answer.gravity && answer.frequency) {
                const criticality = answer.gravity * answer.frequency;
                const display = document.getElementById(`criticalityDisplay_${questionIndex}`);
                if (display) {
                    display.style.display = 'block';
                    display.querySelector('.criticality-value').textContent = criticality;
                    display.querySelector('.criticality-level').textContent = getCriticalityLevel(criticality);
                }
            }
        }

        function getGravityLabel(value) {
            const labels = {
                1: 'Très faible',
                2: 'Faible', 
                3: 'Modérée',
                4: 'Élevée',
                5: 'Très élevée'
            };
            return labels[value] || '';
        }

        function getFrequencyLabel(value) {
            const labels = {
                1: 'Très rare',
                2: 'Rare',
                3: 'Occasionnel', 
                4: 'Fréquent',
                5: 'Très fréquent'
            };
            return labels[value] || '';
        }

        function getCriticalityLevel(criticality) {
            if (criticality <= 5) return 'Risque Faible';
            if (criticality <= 10) return 'Risque Modéré'; 
            if (criticality <= 15) return 'Risque Élevé';
            if (criticality <= 20) return 'Risque Majeur';
            return 'Risque Critique';
        }

        function selectOption(questionIndex, optionIndex, event) {
            userAnswers[questionIndex] = optionIndex;

            // Update UI to show selection
            document.querySelectorAll(`input[name="question_${questionIndex}"]`).forEach(input => {
                input.parentElement.classList.remove('selected');
            });
            if (event && event.currentTarget) {
                event.currentTarget.classList.add('selected');
            } else {
                // fallback: select the label by index
                const labels = document.querySelectorAll(`input[name="question_${questionIndex}"]`);
                if (labels[optionIndex]) {
                    labels[optionIndex].parentElement.classList.add('selected');
                }
            }
        }

        function nextQuestion() {
            console.log('nextQuestion called, currentQuestionIndex:', currentQuestionIndex, 'total questions:', quizQuestions.length);
            
            // Pour la dernière question, permettre de terminer même si pas complètement répondu
            if (currentQuestionIndex === quizQuestions.length - 1) {
                console.log('Last question reached');
                const currentAnswer = userAnswers[currentQuestionIndex];
                if (!currentAnswer || !currentAnswer.gravity || !currentAnswer.frequency) {
                    if (confirm('Cette question n\'est pas complètement répondue. Voulez-vous vraiment terminer le quiz ?')) {
                        console.log('User confirmed to finish incomplete quiz');
                        showResults();
                    }
                    return;
                }
                console.log('Last question completed, showing results');
                showResults();
            } else {
                // Pour les autres questions, validation obligatoire
                const currentAnswer = userAnswers[currentQuestionIndex];
                if (!currentAnswer || !currentAnswer.gravity || !currentAnswer.frequency) {
                    alert('Veuillez évaluer à la fois la gravité et la fréquence de ce risque avant de continuer.');
                    return;
                }
                console.log('Moving to next question');
                currentQuestionIndex++;
                loadQuestion();
            }
        }

        function previousQuestion() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                loadQuestion();
            }
        }

        function showResults() {
            console.log('showResults called');
            let answeredQuestions = 0;
            let totalCriticality = 0;
            let highRiskQuestions = 0;
            let reviewHTML = '';

            quizQuestions.forEach((question, index) => {
                let userAnswer = userAnswers[index];
                
                if (userAnswer && userAnswer.gravity && userAnswer.frequency) {
                    answeredQuestions++;
                    const criticality = userAnswer.gravity * userAnswer.frequency;
                    totalCriticality += criticality;
                    
                    // Count high risk questions (criticality > 15)
                    if (criticality > 15) {
                        highRiskQuestions++;
                    }
                    
                    // Generate review HTML
                    let riskClass = 'low-risk';
                    let criticalityClass = 'criticality-low';
                    if (criticality > 20) {
                        riskClass = 'high-risk';
                        criticalityClass = 'criticality-critical';
                    } else if (criticality > 15) {
                        riskClass = 'high-risk';
                        criticalityClass = 'criticality-high';
                    } else if (criticality > 10) {
                        riskClass = 'medium-risk';
                        criticalityClass = 'criticality-medium';
                    }
                    
                    reviewHTML += `
                        <div class="review-question ${riskClass}">
                            <div class="review-question-text">Q${index + 1}: ${question.question?.substring(0, 100)}${question.question?.length > 100 ? '...' : ''}</div>
                            <div class="review-answer">
                                <span>Gravité: ${userAnswer.gravity} | Fréquence: ${userAnswer.frequency}</span>
                                <span class="review-criticality ${criticalityClass}">
                                    Criticité: ${criticality}
                                </span>
                            </div>
                        </div>
                    `;
                }
            });

            const completionRate = Math.round((answeredQuestions / quizQuestions.length) * 100);
            const averageCriticality = answeredQuestions > 0 ? (totalCriticality / answeredQuestions).toFixed(1) : 0;

            // Safe DOM updates with null checks
            const scoreElement = document.getElementById('resultsScore');
            const correctElement = document.getElementById('correctAnswers');
            const totalElement = document.getElementById('totalAnswers');
            const detailsElement = document.getElementById('resultsDetails');
            const reviewElement = document.getElementById('answersReview');

            if (scoreElement) scoreElement.textContent = completionRate + '%';
            if (correctElement) correctElement.textContent = answeredQuestions;
            if (totalElement) totalElement.textContent = quizQuestions.length;
            
            // Update results details with risk analysis
            if (detailsElement) {
                detailsElement.innerHTML = `
                    Vous avez répondu à <span>${answeredQuestions}</span> questions sur <span>${quizQuestions.length}</span>.<br>
                    <strong>Criticité moyenne :</strong> ${averageCriticality} / 25<br>
                    <strong>Risques élevés identifiés :</strong> ${highRiskQuestions} question(s)
                `;
            }
            
            // Generate answers review
            if (reviewElement) {
                reviewElement.innerHTML = reviewHTML || '<p style="text-align: center; color: rgba(255, 255, 255, 0.5);">Aucune réponse enregistrée</p>';
            }

            // Safe display updates
            const contentElement = document.getElementById('quizContent');
            const navigationElement = document.getElementById('quizNavigation');
            const resultsElement = document.getElementById('quizResults');

            if (contentElement) contentElement.style.display = 'none';
            if (navigationElement) navigationElement.style.display = 'none';
            if (resultsElement) resultsElement.style.display = 'block';
        }

        function reviewAnswers() {
            // Retourner à la première question pour révision
            currentQuestionIndex = 0;
            loadQuestion();
        }

        function submitQuiz() {
            if (!currentCampaign) {
                alert('Erreur: Campagne non trouvée');
                return;
            }
            
            // Vérifier qu'il y a des réponses
            const hasAnswers = Object.keys(userAnswers).some(key => 
                userAnswers[key] && userAnswers[key].gravity && userAnswers[key].frequency
            );
            
            if (!hasAnswers) {
                alert('Veuillez répondre à au moins une question avant de soumettre.');
                return;
            }
            
            // Confirmation avant soumission
            if (!confirm('Voulez-vous vraiment valider définitivement vos réponses ? Cette action ne pourra pas être annulée.')) {
                return;
            }
            
            // Prepare data for submission
            const quizData = {
                campaign_id: currentCampaign.id,
                answers: userAnswers,
                completed_at: new Date().toISOString(),
                _token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            };

            console.log('Submitting quiz data:', quizData);

            // Submit to server
            fetch('/quiz-submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': quizData._token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(quizData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
                
                if (data.success) {
                    // Show success message with detailed information
                    const message = `Quiz soumis avec succès !\n\n` +
                        `Questions répondues: ${data.data.answered_questions}/${data.data.total_questions}\n` +
                        `Progression: ${data.data.completion_percentage}%\n` +
                        `Statut: ${data.data.is_completed ? 'Terminé' : 'En cours'}`;
                    
                    alert(message);
                    closeQuiz();
                    
                    // Force reload to update campaign status
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                } else {
                    alert('Erreur lors de la soumission : ' + (data.message || 'Erreur inconnue'));
                }
            })
            .catch(error => {
                console.error('Submit Error:', error);
                // Pour l'instant, on simule un succès en cas d'erreur de route
                if (error.message.includes('404') || error.message.includes('HTTP error')) {
                    alert('Fonctionnalité en développement. Vos réponses ont été enregistrées localement.');
                    // Sauvegarder en localStorage temporairement
                    localStorage.setItem(`quiz_${currentCampaign.id}`, JSON.stringify(quizData));
                    closeQuiz();
                } else {
                    alert('Erreur lors de la soumission : ' + error.message);
                }
            });
        }

        function closeQuiz() {
            document.getElementById('quizModal').classList.remove('active');
            currentCampaign = null;
            currentQuestionIndex = 0;
            userAnswers = {};
        }

        function viewResults(campaignId) {
            // Redirect to results page
            window.location.href = `/questions/campaigns/${campaignId}/results`;
        }

        function previewCampaign(campaignId) {
            // Load campaign preview
            alert('Fonctionnalité d\'aperçu en développement');
        }

        // Close quiz modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeQuiz();
            }
        });
    </script>
</x-app-layout>