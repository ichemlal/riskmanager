<x-app-layout>
    <div class="page-header">
        <h1>Campagnes de Prévention</h1>
        <p>Gérez et suivez vos campagnes de sensibilisation aux risques professionnels</p>
    </div>

    <!-- Campaign Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon purple">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7v10c0 5.55 3.84 9.95 9 11 5.16-1.05 9-5.45 9-11V7l-10-5z"/>
                    </svg>
                </div>
                <div class="stat-change positive">+12%</div>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['activeCampaigns'] }}</h3>
                <p>Campagnes Actives</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon green">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-change positive">+8%</div>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['trainedEmployees'] }}</h3>
                <p>Employés Formés</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon blue">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="stat-change positive">+15%</div>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['participationRate'] }}%</h3>
                <p>Taux de Participation</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon red">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                </div>
                <div class="stat-change negative">-3%</div>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['urgentCampaigns'] }}</h3>
                <p>Campagnes Urgentes</p>
            </div>
        </div>
    </div>

    <!-- Campaign Actions -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div style="display: flex; gap: 15px;">
            <button class="btn btn-primary" onclick="openCreateCampaignModal()">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Nouvelle Campagne
            </button>
            <button class="btn btn-secondary">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                Exporter
            </button>
        </div>
        <div class="search-filter">
            <input type="text" placeholder="Rechercher une campagne..." class="search-input">
            <select class="filter-select">
                <option>Toutes les campagnes</option>
                <option>Actives</option>
                <option>Terminées</option>
                <option>En préparation</option>
            </select>
        </div>
    </div>

    <!-- Campaigns Grid -->
    <div class="campaigns-grid">
        @forelse($campagnes as $campagne)
            <div class="campaign-card">
                <div class="campaign-header">
                    <div class="campaign-status {{ 
                        $campagne->date_fin < now() ? 'completed' : 
                        ($campagne->date_debut > now() ? 'pending' : 'active')
                    }}">
                        @if($campagne->date_fin < now())
                            Terminé
                        @elseif($campagne->date_debut > now())
                            En préparation
                        @else
                            Actif
                        @endif
                    </div>
                    <div class="campaign-menu">
                        <button onclick="toggleMenu({{ $campagne->id }})">⋮</button>
                        <div class="menu-dropdown" id="menu-{{ $campagne->id }}">
                            <a href="#" onclick="editCampaign({{ $campagne->id }})">Modifier</a>
                            <a href="#" onclick="viewResults({{ $campagne->id }})">Voir les résultats</a>
                            <a href="#" onclick="duplicateCampaign({{ $campagne->id }})">Dupliquer</a>
                            <a href="#" onclick="deleteCampaign({{ $campagne->id }})" class="danger">Supprimer</a>
                        </div>
                    </div>
                </div>
                <div class="campaign-content">
                    <h3>{{ $campagne->nom }}</h3>
                    <p>{{ $campagne->description }}</p>
                    <div class="campaign-meta">
                        <div class="meta-item">
                            <span class="meta-label">Début:</span>
                            <span>{{ \Carbon\Carbon::parse($campagne->date_debut)->format('d M Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Fin:</span>
                            <span>{{ \Carbon\Carbon::parse($campagne->date_fin)->format('d M Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Participants:</span>
                            <span>{{ $campagne->participants }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Groupes:</span>
                            <span>
                                {{ $campagne->groupes->pluck('nom')->join(', ') }}
                            </span>
                        </div>
                    </div>
                    <div class="progress-bar">
                        @php
                            // Dummy progress: you can replace with real logic
                            $progress = min(100, intval(rand(30, 100)));
                        @endphp
                        <div class="progress-fill" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="progress-text">{{ $progress }}% complété</div>
                </div>
            </div>
        @empty
            <div style="color:white;text-align:center;width:100%;">Aucune campagne pour le moment.</div>
        @endforelse
    </div>

    <!-- Recent Activity -->
    <div class="alerts-card" style="margin-top: 40px;">
        <h3>Activité Récente</h3>
        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-icon success">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="activity-content">
                    <div class="activity-title">Formation Sécurité Incendie</div>
                    <div class="activity-description">5 nouveaux participants ont terminé la formation</div>
                    <div class="activity-time">Il y a 2 heures</div>
                </div>
            </div>
            
            <div class="activity-item">
                <div class="activity-icon warning">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                </div>
                <div class="activity-content">
                    <div class="activity-title">Manipulation Produits Chimiques</div>
                    <div class="activity-description">Rappel envoyé à 13 participants en retard</div>
                    <div class="activity-time">Il y a 4 heures</div>
                </div>
            </div>
            
            <div class="activity-item">
                <div class="activity-icon info">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                    </svg>
                </div>
                <div class="activity-content">
                    <div class="activity-title">Prévention des TMS</div>
                    <div class="activity-description">Nouvelle campagne créée et programmée</div>
                    <div class="activity-time">Il y a 1 jour</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Création Campagne -->
   <!-- Modal Création Campagne Wrapper -->
    <div id="createCampaignModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 hidden">
        <div class="modal-content">
            <div class="swiper" id="campaignWizard">
                <div class="swiper-wrapper">
                    <!-- Étape 1 : Nom et Description -->
                    <div class="swiper-slide campaign-step" data-step="1">
                        <h2 class="text-xl font-bold mb-4">Étape 1 : Informations de base</h2>
                        <label for="campaignName" class="block font-semibold">Nom de la campagne :</label>
                        <input type="text" id="campaignName" class="input-field mb-4" />

                        <label for="campaignDescription" class="block font-semibold">Description :</label>
                        <textarea id="campaignDescription" class="input-field mb-4"></textarea>

                        <div class="flex justify-end gap-2">
                            <button class="btn btn-primary" onclick="goToNextStep()">Suivant</button>
                        </div>
                    </div>

                    <!-- Étape 2 : Dates -->
                    <div class="swiper-slide campaign-step" data-step="2">
                        <h2 class="text-xl font-bold mb-4">Étape 2 : Dates</h2>
                        <label for="campaignStart" class="block font-semibold">Date de début :</label>
                        <input type="date" id="campaignStart" class="input-field mb-4" />

                        <label for="campaignEnd" class="block font-semibold">Date de fin :</label>
                        <input type="date" id="campaignEnd" class="input-field mb-4" />

                        <div class="flex justify-between gap-2">
                            <button class="btn btn-secondary" onclick="goToPrevStep()">Précédent</button>
                            <button class="btn btn-primary" onclick="goToNextStep()">Suivant</button>
                        </div>
                    </div>

                    <!-- Étape 3 : Ciblage amélioré -->
                    <div class="swiper-slide campaign-step" data-step="3">
                        <h2 class="text-xl font-bold mb-4">Étape 3 : Ciblage</h2>
                        <div class="mb-4">
                            <div class="flex gap-2 mb-2">
                                <button type="button" class="btn btn-secondary" id="tab-multigroup" onclick="setTargetTab('multigroup')">Groupes</button>
                                <button type="button" class="btn btn-secondary" id="tab-persons" onclick="setTargetTab('persons')">Personnes spécifiques</button>
                            </div>
                            <div id="target-multigroup" class="target-tab">
                                <label for="campaignTargetMultiGroup" class="block font-semibold">Groupes ciblés :</label>
                                <select id="campaignTargetMultiGroup" class="input-field mb-2" multiple onchange="updateSelectedGroupsTable();updateParticipantsCount();">
                                    @foreach($groupes as $groupe)
                                        <option value="{{ $groupe->id }}" data-count="{{ $groupe->salaries_count }}">{{ $groupe->nom }}</option>
                                    @endforeach
                                </select>
                                <table id="selectedGroupsTable" class="mt-2" style="width:100%; color:white;">
                                    <thead>
                                        <tr>
                                            <th>Nom du groupe</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Rempli dynamiquement -->
                                    </tbody>
                                </table>
                            </div>
                            <div id="target-persons" class="target-tab hidden">
                                <label for="campaignTargetPersons" class="block font-semibold">Personnes spécifiques :</label>
                                <input type="text" id="campaignTargetPersons" class="input-field mb-2" placeholder="Tapez les emails séparés par des virgules" />
                                <small class="text-gray-400">Exemple : alice@entreprise.com, bob@entreprise.com</small>
                            </div>
                        </div>
                        <label for="campaignParticipants" class="block font-semibold">Nombre de participants estimé :</label>
                        <input type="number" id="campaignParticipants" class="input-field mb-4" readonly />

                        <div class="flex justify-between gap-2">
                            <button class="btn btn-secondary" onclick="goToPrevStep()">Précédent</button>
                            <button class="btn btn-primary" onclick="goToNextStep()">Suivant</button>
                        </div>
                    </div>

                    <!-- Étape 4 : Choix des questions -->
                    <div class="swiper-slide campaign-step" data-step="4">
                        <h2 class="text-xl font-bold mb-4 text-center text-green-400 flex items-center justify-center gap-2">
        <span style="font-size:1.7rem;">📝</span> Sélectionnez les questions à inclure
    </h2>
    <div class="question-filter-bar" style="display:flex;gap:12px;align-items:center;position:sticky;top:0;z-index:2;background:rgba(17,24,39,0.95);padding:14px 0 10px 0;">
        <select id="questionCategoryFilter" class="input-field" onchange="filterQuestions()" style="min-width:180px;">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
        </select>
        <input type="text" id="questionSearch" class="input-field" placeholder="🔍 Rechercher une question..." oninput="filterQuestions()" style="flex:1;min-width:200px;">
    </div>
    <div style="padding: 18px 0 8px 0;">
        <label class="select-all-label" style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
            <input type="checkbox" id="selectAllQuestions" class="custom-checkbox" onchange="toggleSelectAllQuestions()" />
            <span style="color:#fff;font-weight:500;">Tout sélectionner</span>
        </label>
        <div class="questions-cards-list" id="questionsList">
            @foreach($questions as $q)
            <div class="question-card" 
                data-category="{{ $q->category }}" 
                data-label="{{ strtolower($q->question) }}">
                <label class="question-card-label">
                    <input type="checkbox" class="question-checkbox custom-checkbox" value="{{ $q->id }}" />
                    <div class="question-card-content">
                        <div class="question-card-title">{{ $q->question }}</div>
                        <div class="question-card-meta" style="margin-top:6px;display:flex;gap:8px;font-size:13px;color:rgba(255,255,255,0.7);">
                            <span class="category-badge {{ $q->category }}">{{ $q->category }}</span>
                            <span class="type-badge {{ $q->type }}">{{ $q->type }}</span>
                            @if(!empty($q->priority))
                                <span class="priority-badge {{ $q->priority }}">{{ $q->priority }}</span>
                            @endif
                        </div>
                    </div>
                </label>
            </div>
            @endforeach
        </div>
    </div>
    <div class="flex justify-between gap-2 mt-4">
        <button class="btn btn-secondary" onclick="goToPrevStep()">Précédent</button>
        <button class="btn btn-primary" onclick="goToNextStep()">Suivant</button>
    </div>
                    </div>

                    <!-- Étape 5 : Confirmation -->
                    <div class="swiper-slide campaign-step" data-step="5">
                        <div class="confirmation-center">
        <div class="mb-4 animate-bounce" style="text-align:center;">
            <span style="font-size:3rem;display:inline-block;">🎉</span>
        </div>
        <h2 class="confirmation-title">
            <span style="font-size:2rem;vertical-align:middle;">✅</span>
            Campagne prête à être créée !
        </h2>
        <div class="confirmation-details">
            <div class="confirmation-row"><span>🏷️</span> <strong>Nom :</strong> <span id="confirmName"></span></div>
            <div class="confirmation-row"><span>📝</span> <strong>Description :</strong> <span id="confirmDescription"></span></div>
            <div class="confirmation-row"><span>📅</span> <strong>Date de début :</strong> <span id="confirmStart"></span></div>
            <div class="confirmation-row"><span>📅</span> <strong>Date de fin :</strong> <span id="confirmEnd"></span></div>
            <div class="confirmation-row"><span>🎯</span> <strong>Cible :</strong> <span id="confirmTarget"></span></div>
            <div class="confirmation-row"><span>👥</span> <strong>Participants :</strong> <span id="confirmParticipants"></span></div>
        </div>
        <div class="flex justify-center gap-2 mt-4">
            <button class="btn btn-secondary" onclick="goToPrevStep()">Précédent</button>
            <button class="btn btn-success animate-pulse" onclick="submitCampaign()">🚀 Créer la campagne</button>
        </div>
    </div>
                    </div>

                    <!-- Étape 6 : Succès -->
                    <div class="swiper-slide campaign-step" data-step="6">
                        <div class="text-center">
                            <h2 class="text-2xl font-bold mb-4 text-green-600">🎉 Campagne créée avec succès !</h2>
                            <p class="mb-6">Vous pouvez maintenant la gérer depuis votre tableau de bord.</p>
                            <button class="btn btn-primary" onclick="closeCreateCampaignModal()">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
         .modal-content {
            background: #1f2937;
            padding: 30px;
            border-radius: 16px;
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }
        .input-field {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            color: white;
            font-size: 14px;
        }
        .input-field:focus {
            outline: none;
            border-color: #8b44ff;
            box-shadow: 0 0 0 3px rgba(139,68,255,0.2);
        }
        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
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

        /* Search and Filter */
        .search-filter {
            display: flex;
            gap: 15px;
        }

        .search-input, .filter-select {
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: white;
            font-size: 14px;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .search-input:focus, .filter-select:focus {
            outline: none;
            border-color: #8b44ff;
            box-shadow: 0 0 0 3px rgba(139, 68, 255, 0.2);
        }

        /* Campaigns Grid */
        .campaigns-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .campaign-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 25px;
            transition: all 0.3s ease;
            position: relative;
        }

        .campaign-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 68, 255, 0.3);
        }

        .campaign-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .campaign-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .campaign-status.active {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
        }

        .campaign-status.pending {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
        }

        .campaign-status.urgent {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
        }

        .campaign-status.completed {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
        }

        .campaign-menu {
            position: relative;
        }

        .campaign-menu button {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            font-size: 20px;
            cursor: pointer;
            padding: 5px;
            border-radius: 5px;
        }

        .campaign-menu button:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .menu-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 8px 0;
            min-width: 150px;
            display: none;
            z-index: 1000;
        }

        .menu-dropdown.show {
            display: block;
        }

        .menu-dropdown a {
            display: block;
            padding: 10px 16px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.2s;
        }

        .menu-dropdown a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .menu-dropdown a.danger {
            color: #f87171;
        }

        .campaign-content h3 {
            color: white;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .campaign-content p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .campaign-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .meta-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 500;
        }

        .meta-item span:last-child {
            color: white;
            font-weight: 600;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .progress-fill.completed {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }

        .urgent-progress .progress-fill {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .progress-text {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
        }

        /* Activity List */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .activity-icon {
            flex-shrink: 0;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .activity-icon.success {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
        }

        .activity-icon.warning {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
        }

        .activity-icon.info {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: white;
            margin-bottom: 5px;
        }

        .activity-description {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 5px;
        }

        .activity-time {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .search-filter {
                flex-direction: column;
            }
            
            .campaigns-grid {
                grid-template-columns: 1fr;
            }
            
            .campaign-meta {
                grid-template-columns: 1fr;
            }
        }

        /* Modal Styles */
        .campaign-step {
            padding: 10px 0;
        }

        .campaign-step label {
            margin-bottom: 6px;
            font-weight: 500;
        }

        .campaign-step input,
        .campaign-step textarea {
            width: 100%;
            padding: 12px 12px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            color: white;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .campaign-step input:focus,
        .campaign-step textarea:focus {
            outline: none;
            border-color: #8b44ff;
            box-shadow: 0 0 0 3px rgba(139,68,255,0.2);
        }

        #createCampaignModal {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.7);
        }
        .target-tab { margin-top: 10px; }
        .btn-primary, .btn-secondary { min-width: 120px; }
        .hidden {
    display: none !important;
}
.ts-control, .ts-dropdown, .ts-control input {
    background: rgba(31,41,55,1) !important; /* Same as your modal background */
    color: #fff !important;
    border: 1px solid rgba(255,255,255,0.2) !important;
}

.ts-control {
    border-radius: 10px !important;
    min-height: 44px;
}

.ts-dropdown {
    border-radius: 10px !important;
    color: #fff !important;
}

.ts-control .item {
    background: #8b44ff !important;
    color: #fff !important;
    border-radius: 6px;
    padding: 4px 10px 4px 6px !important;
    margin-right: 4px;
    display: flex;
    align-items: center;
    font-weight: 600;
}

.ts-control .item .remove {
    color: #fff !important;
    margin-right: 4px;
    margin-left: -4px;
    font-size: 18px;
    opacity: 0.8;
    cursor: pointer;
}

.ts-control .item .remove:hover {
    color: #ffb4b4 !important;
    opacity: 1;
}

/* Espacement du select */
#campaignTargetMultiGroup {
    min-height: 80px;
    margin-bottom: 18px;
    font-size: 15px;
}

/* Table des groupes sélectionnés */
#selectedGroupsTable {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-bottom: 18px;
    background: rgba(255,255,255,0.03);
    border-radius: 10px;
    overflow: hidden;
}

#selectedGroupsTable th, #selectedGroupsTable td {
    padding: 12px 16px;
    text-align: left;
}

#selectedGroupsTable th {
    background: rgba(139,68,255,0.15);
    color: #cfcfff;
    font-weight: 600;
    font-size: 15px;
}

#selectedGroupsTable tr {
    border-bottom: 1px solid rgba(255,255,255,0.07);
}

#selectedGroupsTable tr:last-child {
    border-bottom: none;
}

#selectedGroupsTable td {
    background: transparent;
    color: #fff;
    font-size: 15px;
}

#selectedGroupsTable button {
    padding: 7px 16px;
    border-radius: 8px;
    font-size: 14px;
    border: none;
    background: #8b44ff;
    color: #fff;
    cursor: pointer;
    transition: background 0.2s;
}

#selectedGroupsTable button:hover {
    background: #3b82f6;
}

@keyframes bounce {
  0%, 100% { transform: translateY(0);}
  50% { transform: translateY(-15px);}
}
.animate-bounce { animation: bounce 1s infinite; }

@keyframes pulse {
  0%, 100% { opacity: 1;}
  50% { opacity: 0.6;}
}
.animate-pulse { animation: pulse 1.2s infinite; }

.confirmation-center {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 60vh;
}

.confirmation-title {
    text-align: center;
    color: #22c55e;
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.confirmation-details {
    display: flex;
    flex-direction: column;
    gap: 14px;
    background: rgba(34,197,94,0.07);
    padding: 28px 36px;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(34,197,94,0.08);
    margin-bottom: 32px;
    min-width: 320px;
}

.confirmation-row {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.08rem;
    color: #fff;
}

/* Custom styles for questions step */
.question-filter-bar {
    border-bottom: 1px solid rgba(255,255,255,0.07);
    margin-bottom: 10px;
    background: rgba(17,24,39,0.95);
    border-radius: 12px 12px 0 0;
}

.questions-cards-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 18px;
    max-height: 340px;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 16px 12px 8px 12px; /* Add padding */
}

.question-card {
    background: rgba(31,41,55,0.97);
    border: 1.5px solid rgba(139,68,255,0.13);
    border-radius: 12px;
    box-shadow: 0 2px 12px 0 rgba(139,68,255,0.04);
    transition: border 0.2s, box-shadow 0.2s, transform 0.15s;
    padding: 0;
    cursor: pointer;
    position: relative;
    min-height: 90px;
    display: flex;
    align-items: stretch;
}

.question-card:hover, .question-card input:checked ~ .question-card-content {
    border-color: #8b44ff;
    box-shadow: 0 4px 24px 0 rgba(139,68,255,0.13);
    transform: translateY(-2px) scale(1.01);
}

.question-card-label {
    display: flex;
    align-items: center;
    width: 100%;
    cursor: pointer;
    padding: 0;
    margin: 0;
    gap: 18px; /* Space between checkbox and content */
}

.custom-checkbox {
    appearance: none;
    width: 15px;         /* Fix width */
    height: 18px;        /* Fix height */
    min-width: 18px;     /* Prevent shrinking */
    max-width: 18px;
    border: 2px solid #8b44ff;
    border-radius: 7px;
    background: #23263a;
    transition: border 0.2s, box-shadow 0.2s;
    position: relative;
    cursor: pointer;
    margin: 10px 0 10px 10px; /* Align with text */
    display: inline-block;
    vertical-align: middle;
}
.custom-checkbox:checked {
    background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
    border-color: #8b44ff;
}
.custom-checkbox:checked::after {
    content: '';
    display: block;
    position: absolute;
    left: 7px;
    top: 3px;
    width: 7px;
    height: 13px;
    border: solid #fff;
    border-width: 0 3px 3px 0;
    border-radius: 2px;
    transform: rotate(45deg);
}
.custom-checkbox:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(139,68,255,0.18);
}
.select-all-label {
    user-select: none;
}

/* Category, Type, and Priority Badges */
.category-badge.chimique { background: rgba(139, 68, 255, 0.3); color: #a855f7; }
.category-badge.psychosocial { background: rgba(236, 72, 153, 0.3); color: #f472b6; }
.category-badge.securite { background: rgba(239, 68, 68, 0.3); color: #f87171; }
.category-badge.hygiene { background: rgba(34, 197, 94, 0.3); color: #4ade80; }
.category-badge.environnement { background: rgba(59, 130, 246, 0.3); color: #60a5fa; }
.category-badge.ergonomie { background: rgba(245, 158, 11, 0.3); color: #fbbf24; }

.type-badge.multiple { background: rgba(59, 130, 246, 0.2); color: #60a5fa; }
.type-badge.boolean { background: rgba(34, 197, 94, 0.2); color: #4ade80; }
.type-badge.text { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
.type-badge.numeric { background: rgba(139, 68, 255, 0.2); color: #a855f7; }

.priority-badge.critique { background: rgba(239, 68, 68, 0.2); color: #f87171; }
.priority-badge.haute { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
.priority-badge.moyenne { background: rgba(59, 130, 246, 0.2); color: #60a5fa; }
.priority-badge.faible { background: rgba(34, 197, 94, 0.2); color: #4ade80; }

.category-badge, .type-badge, .priority-badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    margin-right: 6px;
    display: inline-block;
}
    </style>

    <!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <script>
    let swiper;
    document.addEventListener('DOMContentLoaded', () => {
        swiper = new Swiper('#campaignWizard', { allowTouchMove: false });
        setTargetTab('multigroup');
        updateSelectedGroupsTable();
    });

    function getCurrentStep() {
        return swiper.activeIndex + 1;
    }

    function goToNextStep() {
        const step = getCurrentStep();
        if (validateStep(step)) {
            swiper.slideTo(step); // step is 1-based, slideTo is 0-based
            if (step + 1 === 4) fillConfirmation();
        }
    }

    function goToPrevStep() {
        const step = getCurrentStep();
        if (step > 1) {
            swiper.slideTo(step - 2);
        }
    }

    function setTargetTab(tab) {
        document.querySelectorAll('.target-tab').forEach(el => el.classList.add('hidden'));
        document.getElementById('target-' + tab).classList.remove('hidden');
        document.getElementById('tab-multigroup').classList.remove('btn-primary');
        document.getElementById('tab-persons').classList.remove('btn-primary');
        document.getElementById('tab-multigroup').classList.add('btn-secondary');
        document.getElementById('tab-persons').classList.add('btn-secondary');
        document.getElementById('tab-' + tab).classList.add('btn-primary');
        document.getElementById('tab-' + tab).classList.remove('btn-secondary');
        if(tab === 'multigroup') updateSelectedGroupsTable();
        updateParticipantsCount();
    }

    function openCreateCampaignModal() {
        document.getElementById('createCampaignModal').classList.remove('hidden');
        swiper.slideTo(0);
        setTargetTab('multigroup');
    }

    function fillConfirmation() {
        document.getElementById('confirmName').textContent = document.getElementById('campaignName').value;
        document.getElementById('confirmDescription').textContent = document.getElementById('campaignDescription').value;
        document.getElementById('confirmStart').textContent = document.getElementById('campaignStart').value;
        document.getElementById('confirmEnd').textContent = document.getElementById('campaignEnd').value;

        let target = '';
        if (!document.getElementById('target-multigroup').classList.contains('hidden')) {
            const options = Array.from(document.getElementById('campaignTargetMultiGroup').selectedOptions);
            target = options.map(o => o.text).join(', ');
        } else if (!document.getElementById('target-persons').classList.contains('hidden')) {
            target = document.getElementById('campaignTargetPersons').value;
        }
        document.getElementById('confirmTarget').textContent = target;
        document.getElementById('confirmParticipants').textContent = document.getElementById('campaignParticipants').value;
    }

    function validateStep(step) {
        if (step === 1 && !document.getElementById('campaignName').value) {
            alert('Veuillez entrer un nom de campagne.');
            return false;
        }
        if (step === 2) {
            const start = document.getElementById('campaignStart').value;
            const end = document.getElementById('campaignEnd').value;
            if (!start || !end) {
                alert('Veuillez remplir les dates.');
                return false;
            }
            if (new Date(end) < new Date(start)) {
                alert("La date de fin doit être après la date de début.");
                return false;
            }
        }
        return true;
    }

    function submitCampaign() {
        // Récupérer les données du formulaire
        const groupes = Array.from(document.getElementById('campaignTargetMultiGroup').selectedOptions).map(opt => opt.value);
        const emails = document.getElementById('campaignTargetPersons').value;
        const questions = getSelectedQuestions();
        const data = {
            nom: document.getElementById('campaignName').value,
            description: document.getElementById('campaignDescription').value,
            date_debut: document.getElementById('campaignStart').value,
            date_fin: document.getElementById('campaignEnd').value,
            groupes: groupes,
            participants: document.getElementById('campaignParticipants').value,
            questions: questions,
            _token: '{{ csrf_token() }}'
        };

        fetch('{{ route('campagnes.store') }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(async response => {
            if (response.ok) {
                swiper.slideTo(5); // Go to success step (6th slide, index 5)
            } else {
                const error = await response.json();
                alert('Erreur : ' + (error.message || 'Vérifiez les champs du formulaire.'));
            }
        })
        .catch(() => {
            alert('Erreur lors de la création de la campagne.');
        });
    }

    function closeCreateCampaignModal() {
        document.getElementById('createCampaignModal').classList.add('hidden');
        swiper.slideTo(0);
        document.querySelectorAll('#createCampaignModal input, #createCampaignModal textarea').forEach(el => el.value = '');
    }

    function updateSelectedGroupsTable() {
        const select = document.getElementById('campaignTargetMultiGroup');
        const tableBody = document.getElementById('selectedGroupsTable').querySelector('tbody');
        tableBody.innerHTML = '';
        Array.from(select.selectedOptions).forEach(option => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${option.text}</td>
                <td>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="removeGroupFromSelection('${option.value}')">Retirer</button>
                </td>
            `;
            tableBody.appendChild(tr);
        });
    }

    function removeGroupFromSelection(groupId) {
        const select = document.getElementById('campaignTargetMultiGroup');
        Array.from(select.options).forEach(option => {
            if(option.value == groupId) option.selected = false;
        });
        updateSelectedGroupsTable();
    }

    function updateParticipantsCount() {
        // Comptage des groupes sélectionnés
        const select = document.getElementById('campaignTargetMultiGroup');
        let total = 0;
        Array.from(select.selectedOptions).forEach(option => {
            total += parseInt(option.getAttribute('data-count')) || 0;
        });

        // Comptage des emails spécifiques (séparés par virgule)
        const emails = document.getElementById('campaignTargetPersons').value;
        if (!document.getElementById('target-persons').classList.contains('hidden')) {
            const emailCount = emails.split(',').map(e => e.trim()).filter(e => e.length > 0).length;
            total += emailCount;
        }

        document.getElementById('campaignParticipants').value = total;
    }

    // Mets à jour le nombre à chaque changement
    document.getElementById('campaignTargetMultiGroup').addEventListener('change', updateParticipantsCount);
    document.getElementById('campaignTargetPersons').addEventListener('input', updateParticipantsCount);

    // Mets à jour aussi quand on change d’onglet
    function setTargetTab(tab) {
        document.querySelectorAll('.target-tab').forEach(el => el.classList.add('hidden'));
        document.getElementById('target-' + tab).classList.remove('hidden');
        document.getElementById('tab-multigroup').classList.remove('btn-primary');
        document.getElementById('tab-persons').classList.remove('btn-primary');
        document.getElementById('tab-multigroup').classList.add('btn-secondary');
        document.getElementById('tab-persons').classList.add('btn-secondary');
        document.getElementById('tab-' + tab).classList.add('btn-primary');
        document.getElementById('tab-' + tab).classList.remove('btn-secondary');
        if(tab === 'multigroup') updateSelectedGroupsTable();
        updateParticipantsCount();
    }

    // Close menus when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.campaign-menu')) {
            document.querySelectorAll('.menu-dropdown').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });

    // Appeler la fonction au chargement pour afficher si déjà sélectionné
    document.addEventListener('DOMContentLoaded', () => {
        setTargetTab('multigroup');
        updateSelectedGroupsTable();
    });

    function filterQuestions() {
        const cat = document.getElementById('questionCategoryFilter').value;
        const search = document.getElementById('questionSearch').value.toLowerCase();
        let allVisibleChecked = true;
        let anyVisible = false;
        document.querySelectorAll('#questionsList .question-card').forEach(card => {
            const matchCat = !cat || card.getAttribute('data-category') === cat;
            const matchSearch = !search || card.getAttribute('data-label').includes(search);
            const visible = (matchCat && matchSearch);
            card.style.display = visible ? '' : 'none';
            if (visible) {
                anyVisible = true;
                const cb = card.querySelector('.question-checkbox');
                if (!cb.checked) allVisibleChecked = false;
            }
        });
        document.getElementById('selectAllQuestions').checked = anyVisible && allVisibleChecked;
    }

    function getSelectedQuestions() {
        return Array.from(document.querySelectorAll('.question-checkbox:checked')).map(cb => cb.value);
    }

    function toggleSelectAllQuestions() {
        const checked = document.getElementById('selectAllQuestions').checked;
        document.querySelectorAll('#questionsList .question-checkbox').forEach(cb => {
        if (cb.offsetParent !== null) { // only visible
            cb.checked = checked;
        }
    });
    }
</script>
</x-app-layout>