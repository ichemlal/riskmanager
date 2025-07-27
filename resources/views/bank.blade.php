<x-app-layout>
    <div class="content-max">
        <!-- Page Header -->
        <div class="page-header">
            <div class="flex justify-between items-start">
                <div>
                    <h1>Banque de Questions</h1>
                    <p>Gérez et organisez toutes les questions d'évaluation des risques</p>
                </div>
                <button onclick="openAddQuestionModal()" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Ajouter une Question
                </button>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="filters-section">
            <div class="filters-grid">
                <div class="search-box">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="searchInput" placeholder="Rechercher une question..." onkeyup="filterQuestions()">
                </div>
                
                <select id="categoryFilter" onchange="filterQuestions()" class="filter-select">
                    <option value="">Toutes les catégories</option>
                    <option value="securite">Sécurité</option>
                    <option value="hygiene">Hygiène</option>
                    <option value="environnement">Environnement</option>
                    <option value="ergonomie">Ergonomie</option>
                    <option value="chimique">Risques Chimiques</option>
                    <option value="psychosocial">Risques Psychosociaux</option>
                </select>

                <select id="typeFilter" onchange="filterQuestions()" class="filter-select">
                    <option value="">Tous les types</option>
                    <option value="multiple">Choix Multiple</option>
                    <option value="boolean">Oui/Non</option>
                    <option value="text">Texte Libre</option>
                    <option value="numeric">Numérique</option>
                </select>

                <select id="priorityFilter" onchange="filterQuestions()" class="filter-select">
                    <option value="">Toutes les priorités</option>
                    <option value="critique">Critique</option>
                    <option value="haute">Haute</option>
                    <option value="moyenne">Moyenne</option>
                    <option value="faible">Faible</option>
                </select>
            </div>
        </div>

        <!-- Questions Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon purple">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-change positive">+12</div>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['totalQuestions'] }}</h3>
                    <p>Total Questions</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon green">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-change positive">+8</div>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['activeQuestions'] }}</h3>
                    <p>Questions Actives</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon blue">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="stat-change positive">+15</div>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['categoriesCount'] }}</h3>
                    <p>Catégories</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon red">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.232 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="stat-change negative">-3</div>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['criticalQuestions'] }}</h3>
                    <p>Questions Critiques</p>
                </div>
            </div>
        </div>

        <!-- Questions List -->
        <div class="questions-container">
            <div class="questions-header">
                <h3>Liste des Questions</h3>
                <div class="questions-actions">
                    <button onclick="exportQuestions()" class="btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Exporter
                    </button>
                    <button onclick="importQuestions()" class="btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                        </svg>
                        Importer
                    </button>
                </div>
            </div>

            <div id="questionsList" class="questions-list">
                <!-- Questions will be rendered here by JS -->
            </div>
        </div>
    </div>

    <!-- Add/Edit Question Modal -->
    <div id="questionModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Ajouter une Question</h3>
                <button onclick="closeModal()" class="modal-close">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="questionForm" class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Question *</label>
                        <textarea id="questionText" placeholder="Saisissez votre question..." rows="3" required></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Catégorie *</label>
                            <select id="questionCategory" required>
                                <option value="">Sélectionner...</option>
                                <option value="securite">Sécurité</option>
                                <option value="hygiene">Hygiène</option>
                                <option value="environnement">Environnement</option>
                                <option value="ergonomie">Ergonomie</option>
                                <option value="chimique">Risques Chimiques</option>
                                <option value="psychosocial">Risques Psychosociaux</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Type de Risque</label>
                            <select id="questionRiskCategory">
                                <option value="general">Général</option>
                                <option value="physique">Physique</option>
                                <option value="chimique">Chimique</option>
                                <option value="biologique">Biologique</option>
                                <option value="psychosocial">Psychosocial</option>
                                <option value="ergonomique">Ergonomique</option>
                                <option value="environnemental">Environnemental</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Type de Question</label>
                            <input type="text" value="Échelle Gravité-Fréquence" readonly style="background: rgba(255, 255, 255, 0.1); color: #ccc;">
                            <input type="hidden" id="questionType" value="gravity-frequency">
                        </div>
                        
                        <div class="form-group">
                            <label>Aide pour l'évaluation</label>
                            <textarea id="questionHelp" placeholder="Aide pour évaluer la gravité et la fréquence de ce risque..." rows="3"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Exemples de Gravité et Fréquence</label>
                            <textarea id="questionExamples" placeholder="Exemples concrets pour guider l'évaluation (1=très faible, 5=très élevé)..." rows="2"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Instructions/Notes</label>
                        <textarea id="questionNotes" placeholder="Instructions supplémentaires ou notes..." rows="2"></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" onclick="closeModal()" class="btn-secondary">Annuler</button>
                    <button type="submit" class="btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .content-max {
            max-width: 1200px;
            margin: 0 auto;
        }

        .btn-primary {
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 68, 255, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .filters-section {
            margin-bottom: 30px;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 20px;
            align-items: center;
        }

        .search-box {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: rgba(255, 255, 255, 0.5);
        }

        .search-box input {
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 15px 15px 15px 45px;
            color: white;
            font-size: 14px;
        }

        .search-box input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .filter-select {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 15px;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        .filter-select option {
            background: #1a1a2e;
            color: white;
        }

        .questions-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 30px;
        }

        .questions-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .questions-header h3 {
            color: white;
            font-size: 24px;
            font-weight: 600;
        }

        .questions-actions {
            display: flex;
            gap: 15px;
        }

        .questions-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .question-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .question-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-2px);
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .question-meta {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .question-id {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .category-badge, .type-badge, .priority-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .category-badge.securite { background: rgba(239, 68, 68, 0.3); color: #f87171; }
        .category-badge.hygiene { background: rgba(34, 197, 94, 0.3); color: #4ade80; }
        .category-badge.environnement { background: rgba(59, 130, 246, 0.3); color: #60a5fa; }
        .category-badge.ergonomie { background: rgba(245, 158, 11, 0.3); color: #fbbf24; }
        .category-badge.chimique { background: rgba(139, 68, 255, 0.3); color: #a855f7; }
        .category-badge.psychosocial { background: rgba(236, 72, 153, 0.3); color: #f472b6; }

        .type-badge.multiple { background: rgba(59, 130, 246, 0.2); color: #60a5fa; }
        .type-badge.boolean { background: rgba(34, 197, 94, 0.2); color: #4ade80; }
        .type-badge.text { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
        .type-badge.numeric { background: rgba(139, 68, 255, 0.2); color: #a855f7; }

        .priority-badge.critique { background: rgba(239, 68, 68, 0.2); color: #f87171; }
        .priority-badge.haute { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
        .priority-badge.moyenne { background: rgba(59, 130, 246, 0.2); color: #60a5fa; }
        .priority-badge.faible { background: rgba(34, 197, 94, 0.2); color: #4ade80; }

        .question-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .action-btn.edit {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
        }

        .action-btn.edit:hover {
            background: rgba(59, 130, 246, 0.3);
            transform: scale(1.1);
        }

        .action-btn.duplicate {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
        }

        .action-btn.duplicate:hover {
            background: rgba(245, 158, 11, 0.3);
            transform: scale(1.1);
        }

        .action-btn.delete {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
        }

        .action-btn.delete:hover {
            background: rgba(239, 68, 68, 0.3);
            transform: scale(1.1);
        }

        .question-content h4 {
            color: white;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .question-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }

        .boolean-options {
            display: flex;
            gap: 15px;
        }

        .option {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .option.correct {
            background: rgba(34, 197, 94, 0.2);
            border-color: rgba(34, 197, 94, 0.4);
            color: #4ade80;
        }

        .question-input {
            position: relative;
            max-width: 300px;
        }

        .question-input input {
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 12px 50px 12px 15px;
            color: white;
            font-size: 14px;
        }

        .input-unit {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        .question-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .last-updated, .usage-count {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modal-header h3 {
            color: white;
            font-size: 24px;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            padding: 5px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .modal-body {
            padding: 30px;
        }

        .form-grid {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 12px 15px;
            color: white;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #8b44ff;
            box-shadow: 0 0 0 3px rgba(139, 68, 255, 0.2);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-group select option {
            background: #1a1a2e;
            color: white;
        }

        .option-input {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
        }

        .option-input input {
            flex: 1;
            margin: 0;
        }

        .correct-answer {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            cursor: pointer;
        }

        .remove-option {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .add-option {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.4);
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .add-option:hover {
            background: rgba(34, 197, 94, 0.3);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .filters-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .question-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .question-meta {
                order: 2;
            }

            .question-actions {
                order: 1;
                align-self: flex-end;
            }

            .question-options {
                grid-template-columns: 1fr;
            }

            .boolean-options {
                flex-direction: column;
            }

            .question-footer {
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .modal-content {
                width: 95%;
                margin: 20px;
            }

            .modal-header,
            .modal-body {
                padding: 20px;
            }
        }
    </style>

    <script>
        let loadedQuestions = [];
        let editingQuestionId = null;
        // Modal Functions
        function openAddQuestionModal() {
            editingQuestionId = null;
            document.getElementById('modalTitle').textContent = 'Ajouter une Question';
            document.getElementById('questionForm').reset();
            // Remove references to non-existent elements
            document.getElementById('questionModal').classList.add('active');
        }

        function editQuestion(id) {
            editingQuestionId = id;
            const q = loadedQuestions.find(q => q.id === id);
            if (!q) return;

            document.getElementById('modalTitle').textContent = 'Modifier la Question #' + String(id).padStart(3, '0');
            document.getElementById('questionModal').classList.add('active');

            // Fill the fields with existing values
            document.getElementById('questionText').value = q.question || '';
            document.getElementById('questionCategory').value = q.category || '';
            document.getElementById('questionRiskCategory').value = q.risk_category || 'general';
            document.getElementById('questionNotes').value = q.notes || '';
        }

        function closeModal() {
            document.getElementById('questionModal').classList.remove('active');
        }

        function toggleAnswerOptions() {
            // No longer needed - all questions are gravity-frequency type
        }

        // Question Actions
        function duplicateQuestion(id) {
            if (confirm('Voulez-vous dupliquer cette question ?')) {
                // Duplicate logic here
                console.log('Duplicating question:', id);
            }
        }

        function deleteQuestion(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette question ? Cette action est irréversible.')) {
                // Delete logic here
                console.log('Deleting question:', id);
            }
        }

        function exportQuestions() {
            // Export logic here
            console.log('Exporting questions...');
        }

        function importQuestions() {
            // Import logic here
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.json,.csv,.xlsx';
            input.onchange = function(e) {
                const file = e.target.files[0];
                if (file) {
                    console.log('Importing file:', file.name);
                    // Process file here
                }
            };
            input.click();
        }

        // Filtering Functions
        function filterQuestions() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const categoryFilter = document.getElementById('categoryFilter').value;
            const typeFilter = document.getElementById('typeFilter').value;
            const priorityFilter = document.getElementById('priorityFilter').value;
            
            const questions = document.querySelectorAll('.question-item');
            
            questions.forEach(question => {
                const questionText = question.querySelector('h4').textContent.toLowerCase();
                const category = question.dataset.category;
                const type = question.dataset.type;
                const priority = question.dataset.priority;
                
                const matchesSearch = questionText.includes(searchTerm);
                const matchesCategory = !categoryFilter || category === categoryFilter;
                const matchesType = !typeFilter || type === typeFilter;
                const matchesPriority = !priorityFilter || priority === priorityFilter;
                
                if (matchesSearch && matchesCategory && matchesType && matchesPriority) {
                    question.style.display = 'block';
                } else {
                    question.style.display = 'none';
                }
            });
        }

        // Form Submission
        document.getElementById('questionForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = {
                question: document.getElementById('questionText').value,
                category: document.getElementById('questionCategory').value,
                risk_category: document.getElementById('questionRiskCategory').value,
                notes: document.getElementById('questionNotes').value
            };

            // For gravity-frequency questions, no additional answer data needed

            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Detect if edit or create
            let url = '/questions';
            let method = 'POST';
            if (editingQuestionId) {
                url = `/questions/${editingQuestionId}`;
                method = 'PUT';
            }

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (!response.ok) throw new Error('Erreur lors de l\'enregistrement');
                return response.json();
            })
            .then(data => {
                closeModal();
                location.reload(); // Or refresh your list
            })
            .catch(error => {
                alert(error.message || 'Erreur lors de l\'enregistrement');
            });
        });

        // Close modal when clicking outside
        document.getElementById('questionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Fetch and render questions
        async function fetchQuestions() {
            const res = await fetch('/questions', {headers: {'Accept': 'application/json'}});
            if (!res.ok) return [];
            return await res.json();
        }

        function renderQuestions(questions) {
            const list = document.getElementById('questionsList');
            if (!questions.length) {
                list.innerHTML = '<div class="text-white text-center py-8">Aucune question trouvée.</div>';
                return;
            }
            list.innerHTML = questions.map(q => {
                // Fix: decode options if needed
                let options = [];
                if (q.options) {
                    if (typeof q.options === 'string') {
                        try {
                            options = JSON.parse(q.options);
                        } catch (e) {
                            options = [];
                        }
                    } else if (Array.isArray(q.options)) {
                        options = q.options;
                    }
                }
                return `
                    <div class="question-item" data-category="${q.category}" data-type="${q.type}" data-priority="${q.priority}">
                        <div class="question-header">
                            <div class="question-meta">
                                <span class="question-id">#${String(q.id).padStart(3, '0')}</span>
                                <span class="category-badge ${q.category}">${q.category_label || q.category}</span>
                                <span class="type-badge ${q.type}">${q.type_label || q.type}</span>
                                <span class="priority-badge ${q.priority}">${q.priority_label || q.priority}</span>
                            </div>
                            <div class="question-actions">
                                <button onclick="editQuestion(${q.id})" class="action-btn edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="duplicateQuestion(${q.id})" class="action-btn duplicate">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                                <button onclick="deleteQuestion(${q.id})" class="action-btn delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="question-content">
                            <h4>${q.question}</h4>
                            ${q.type === 'multiple' && options.length ? `
                                <div class="question-options">
                                    ${options.map((opt, i) => `
                                        <div class="option${opt.correct ? ' correct' : ''}">${String.fromCharCode(65 + i)}. ${opt.text}</div>
                                    `).join('')}
                                </div>
                            ` : ''}
                            ${q.type === 'boolean' ? `
                                <div class="question-options boolean-options">
                                    <div class="option${q.correct_answer === 'oui' ? ' correct' : ''}">Oui</div>
                                    <div class="option${q.correct_answer === 'non' ? ' correct' : ''}">Non</div>
                                </div>
                            ` : ''}
                            ${q.type === 'numeric' ? `
                                <div class="question-input">
                                    <input type="number" placeholder="Valeur numérique" value="${q.correct_answer || ''}" disabled>
                                </div>
                            ` : ''}
                            ${q.type === 'text' ? `
                                <div class="question-input">
                                    <input type="text" placeholder="Réponse texte" value="${q.correct_answer || ''}" disabled>
                                </div>
                            ` : ''}
                        </div>
                        <div class="question-footer">
                            <span class="last-updated">Dernière modification: ${q.updated_at ? (new Date(q.updated_at)).toLocaleDateString('fr-FR') : ''}</span>
                            <span class="usage-count">${q.usage_count ? `Utilisée ${q.usage_count} fois` : ''}</span>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // On page load, fetch and render questions
        document.addEventListener('DOMContentLoaded', async () => {
            loadedQuestions = await fetchQuestions();
            renderQuestions(loadedQuestions);
        });
    </script>
</x-app-layout>