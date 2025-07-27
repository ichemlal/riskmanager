<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Parametrage') }}
        </h2>
    </x-slot>
<div class="content-max">
    <div class="page-header">
        <h1>Paramétrage</h1>
        <p>Configurez la structure interne : métiers, salariés et groupes homogènes</p>
    </div>

    <div class="tabs-container" style="margin-bottom: 30px;">
        <div class="tabs-nav" style="display: flex; gap: 5px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 5px; margin-bottom: 30px;">
            <button class="tab-btn active" onclick="switchTab('metiers')" 
                style="flex: 1; padding: 12px 20px; border: none; background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%); color: white; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">
                <span style="margin-right: 8px;">🏢</span>Métiers
            </button>
            <button class="tab-btn" onclick="switchTab('salaries')" 
                style="flex: 1; padding: 12px 20px; border: none; background: transparent; color: rgba(255, 255, 255, 0.7); border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">
                <span style="margin-right: 8px;">👥</span>Salariés
            </button>
            <button class="tab-btn" onclick="switchTab('groupes')" 
                style="flex: 1; padding: 12px 20px; border: none; background: transparent; color: rgba(255, 255, 255, 0.7); border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">
                <span style="margin-right: 8px;">🔗</span>Groupes Homogènes
            </button>
        </div>
    </div>

    <div id="metiers-tab" class="tab-content">
        <div class="stat-card" style="margin-bottom: 30px;">
            <div class="stat-header">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div class="stat-icon purple">
                        <span style="font-size: 24px;">🏢</span>
                    </div>
                    <div>
                        <h3 style="color: white; font-size: 24px; margin: 0;">Gestion des Métiers</h3>
                        <p style="color: rgba(255, 255, 255, 0.7); margin: 0;">Définissez les métiers de votre organisation</p>
                    </div>
                </div>
                <button onclick="openMetierModal()" 
                    style="padding: 12px 24px; background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">
                    + Nouveau Métier
                </button>
            </div>
        </div>

        <div class="charts-grid" style="grid-template-columns: 1fr;">
            <div class="chart-card">
                <div class="metiers-list">
                    @foreach($metiers as $metier)
                    <div class="metier-item" style="display: flex; align-items: center; justify-content: space-between; padding: 20px; background: rgba(255, 255, 255, 0.05); border-radius: 12px; margin-bottom: 15px; border: 1px solid rgba(255, 255, 255, 0.1);">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px;">
                                {{ $metier->icon ?? '🏢' }}
                            </div>
                            <div>
                                <h4 style="color: white; margin: 0; font-size: 18px;">{{ $metier->nom }}</h4>
                                <p style="color: rgba(255, 255, 255, 0.6); margin: 0; font-size: 14px;">
                                    {{ $salaries->where('metier_id', $metier->id)->count() }} salariés assignés
                                </p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <button
                                class="edit-metier-btn"
                                data-id="{{ $metier->id }}"
                                data-nom="{{ $metier->nom }}"
                                data-description="{{ $metier->description }}"
                                data-icon="{{ $metier->icon }}"
                                onclick="editMetier(this)"
                                style="padding: 8px 16px; background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: none; border-radius: 8px; cursor: pointer;">
                                ✏️ Modifier
                            </button>
                            <button onclick="deleteMetier({{ $metier->id }})" style="padding: 8px 16px; background: rgba(239, 68, 68, 0.2); color: #f87171; border: none; border-radius: 8px; cursor: pointer;">
                                🗑️ Supprimer
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="salaries-tab" class="tab-content" style="display: none;">
        <div class="stat-card" style="margin-bottom: 30px;">
            <div class="stat-header">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div class="stat-icon green">
                        <span style="font-size: 24px;">👥</span>
                    </div>
                    <div>
                        <h3 style="color: white; font-size: 24px; margin: 0;">Gestion des Salariés</h3>
                        <p style="color: rgba(255, 255, 255, 0.7); margin: 0;">Gérez les profils de vos employés</p>
                    </div>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button onclick="bulkImport()" 
                        style="padding: 12px 24px; background: rgba(34, 197, 94, 0.2); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.4); border-radius: 10px; cursor: pointer; font-weight: 600;">
                        📊 Import en lot
                    </button>
                    <button onclick="openSalarieModal()" 
                        style="padding: 12px 24px; background: linear-gradient(135deg, #34d399 0%, #10b981 100%); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600;">
                        + Nouveau Salarié
                    </button>
                </div>
            </div>
        </div>

        <div class="stat-card" style="margin-bottom: 30px;">
            <div style="display: grid; grid-template-columns: 1fr auto auto; gap: 15px; align-items: end;">
                <div>
                    <label style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Rechercher</label>
                    <input type="text" id="salarie-search" placeholder="Nom, email, métier..." 
                        style="width: 100%; padding: 12px 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; color: white; font-size: 14px;">
                </div>
                <div>
                    <label style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Métier</label>
                    <select id="filter-metier" style="padding: 12px 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; color: white;">
                        <option value="">Tous les métiers</option>
                        @foreach($metiers as $metier)
                            <option value="{{ $metier->id }}">{{ $metier->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <button style="padding: 12px 16px; background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%); color: white; border: none; border-radius: 10px; cursor: pointer;">
                    🔍 Filtrer
                </button>
            </div>
        </div>

        <div class="charts-grid" style="grid-template-columns: 1fr;">
            <div class="chart-card">
                <div class="salaries-list">
                    @foreach($salaries as $salarie)
                    <div class="salarie-item"
                         data-search="{{ strtolower($salarie->prenom.' '.$salarie->nom.' '.$salarie->email.' '.($salarie->metier->nom ?? '')) }}"
                         style="display: flex; align-items: center; justify-content: space-between; padding: 20px; background: rgba(255, 255, 255, 0.05); border-radius: 12px; margin-bottom: 15px; border: 1px solid rgba(255, 255, 255, 0.1);">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div class="user-avatar" style="width: 55px; height: 55px; background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 18px;">
                                {{ strtoupper(substr($salarie->prenom,0,1)) }}{{ strtoupper(substr($salarie->nom,0,1)) }}
                            </div>
                            <div>
                                <h4 style="color: white; margin: 0; font-size: 18px;">{{ $salarie->prenom }} {{ $salarie->nom }}</h4>
                                <p style="color: rgba(255, 255, 255, 0.6); margin: 0; font-size: 14px;">{{ $salarie->email }}</p>
                                <div style="margin-top: 5px;">
                                    <span style="background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                        {{ $salarie->metier->nom ?? '' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <button
                                class="edit-salarie-btn"
                                data-id="{{ $salarie->id }}"
                                data-prenom="{{ $salarie->prenom }}"
                                data-nom="{{ $salarie->nom }}"
                                data-email="{{ $salarie->email }}"
                                data-metier_id="{{ $salarie->metier_id }}"
                                data-telephone="{{ $salarie->telephone }}"
                                data-date_embauche="{{ $salarie->date_embauche }}"
                                onclick="editSalarie(this)"
                                style="padding: 8px 16px; background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: none; border-radius: 8px; cursor: pointer;">
                                ✏️ Modifier
                            </button>
                            <button onclick="resetAccess({{ $salarie->id }})" style="padding: 8px 16px; background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: none; border-radius: 8px; cursor: pointer;">
                                🔑 Reset Accès
                            </button>
                        </div>
                    </div>

                    <!-- <div class="salarie-item" style="display: flex; align-items: center; justify-content: space-between; padding: 20px; background: rgba(255, 255, 255, 0.05); border-radius: 12px; margin-bottom: 15px; border: 1px solid rgba(255, 255, 255, 0.1);">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div class="user-avatar" style="width: 55px; height: 55px; background: linear-gradient(135deg, #34d399 0%, #10b981 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 18px;">
                                ML
                            </div>
                            <div>
                                <h4 style="color: white; margin: 0; font-size: 18px;">Marie Leroy</h4>
                                <p style="color: rgba(255, 255, 255, 0.6); margin: 0; font-size: 14px;">marie.leroy@example.com</p>
                                <div style="margin-top: 5px;">
                                    <span style="background: linear-gradient(135deg, #34d399 0%, #10b981 100%); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                        Administratif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <div style="text-align: center; margin-right: 15px;">
                                <div style="color: #f87171; font-size: 12px; font-weight: 600;">ATTENTE</div>
                                <div style="color: rgba(255, 255, 255, 0.6); font-size: 11px;">Accès à générer</div>
                            </div>
                            <button
                                class="edit-salarie-btn"
                                data-id="{{ $salarie->id }}"
                                data-prenom="{{ $salarie->prenom }}"
                                data-nom="{{ $salarie->nom }}"
                                data-email="{{ $salarie->email }}"
                                data-metier_id="{{ $salarie->metier_id }}"
                                data-telephone="{{ $salarie->telephone }}"
                                data-date_embauche="{{ $salarie->date_embauche }}"
                                onclick="editSalarie(this)"
                                style="padding: 8px 16px; background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: none; border-radius: 8px; cursor: pointer;">
                                ✏️ Modifier
                            </button>
                            <button onclick="generateAccess(2)" style="padding: 8px 16px; background: rgba(34, 197, 94, 0.2); color: #4ade80; border: none; border-radius: 8px; cursor: pointer;">
                                🔑 Générer Accès
                            </button>
                        </div>
                    </div> -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div id="groupes-tab" class="tab-content" style="display: none;">
        <div class="stat-card" style="margin-bottom: 30px;">
            <div class="stat-header">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div class="stat-icon blue">
                        <span style="font-size: 24px;">🔗</span>
                    </div>
                    <div>
                        <h3 style="color: white; font-size: 24px; margin: 0;">Groupes Homogènes</h3>
                        <p style="color: rgba(255, 255, 255, 0.7); margin: 0;">Organisez vos salariés en groupes de travail</p>
                    </div>
                </div>
                <button onclick="openGroupeModal()" 
                    style="padding: 12px 24px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600;">
                    + Nouveau Groupe
                </button>
            </div>
        </div>

        <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
            @foreach($groupes as $groupe)
            <div class="stat-card">
                <div class="stat-header">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div class="stat-icon blue">
                            <span style="font-size: 20px;">🔗</span>
                        </div>
                        <div>
                            <h4 style="color: white; margin: 0; font-size: 18px;">{{ $groupe->nom }}</h4>
                            <p style="color: rgba(255, 255, 255, 0.6); margin: 0; font-size: 14px;">
                                {{ $groupe->salaries->count() }} membre{{ $groupe->salaries->count() > 1 ? 's' : '' }}
                            </p>
                        </div>
                    </div>
                    <button
                        onclick="editGroupe(this)"
                        data-id="{{ $groupe->id }}"
                        data-nom="{{ $groupe->nom }}"
                        data-description="{{ $groupe->description }}"
                        data-membres="{{ $groupe->salaries->pluck('id')->implode(',') }}"
                        style="padding: 6px 12px; background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: none; border-radius: 6px; cursor: pointer; font-size: 12px;">
                        ✏️
                    </button>
                </div>
                
                <div style="margin-top: 20px;">
                    <h5 style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 12px;">Membres du groupe:</h5>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                        @foreach($groupe->salaries->take(6) as $salarie)
                        <div style="display: flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.1); padding: 8px 12px; border-radius: 20px;">
                            <div style="width: 24px; height: 24px; background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; font-weight: 600;">
                                {{ strtoupper(substr($salarie->prenom,0,1)) }}{{ strtoupper(substr($salarie->nom,0,1)) }}
                            </div>
                            <span style="color: white; font-size: 12px;">{{ $salarie->prenom }} {{ strtoupper(substr($salarie->nom,0,1)) }}.</span>
                        </div>
                        @endforeach
                        @if($groupe->salaries->count() > 6)
                        <div style="display: flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.1); padding: 8px 12px; border-radius: 20px;">
                            <div style="width: 24px; height: 24px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; font-weight: 600;">
                                +{{ $groupe->salaries->count() - 6 }}
                            </div>
                            <span style="color: white; font-size: 12px;">et {{ $groupe->salaries->count() - 6 }} autres</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid rgba(255, 255, 255, 0.1);">
                    <div style="display: flex; justify-content: between; align-items: center;">
                        <div style="display: flex; gap: 15px;">
                            <div style="text-align: center;">
                                <div style="color: #4ade80; font-size: 16px; font-weight: 600;">{{ $groupe->evaluations_count ?? 0 }}</div>
                                <div style="color: rgba(255, 255, 255, 0.6); font-size: 11px;">Évaluations</div>
                            </div>
                            <div style="text-align: center;">
                                <div style="color: #60a5fa; font-size: 16px; font-weight: 600;">{{ $groupe->conformite ?? 'N/A' }}</div>
                                <div style="color: rgba(255, 255, 255, 0.6); font-size: 11px;">Conformité</div>
                            </div>
                        </div>
                        <button onclick="manageGroupe({{ $groupe->id }})" style="padding: 8px 16px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 12px;">
                            Gérer →
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

     
    </div>
</div>

<!-- Métier Modal -->
<div id="metier-modal" class="modal" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 2000; backdrop-filter: blur(8px);">
    <div class="modal-content"
         style="max-width: 600px; margin: 100px auto; background: rgba(30, 41, 59, 0.9); border-radius: 12px; padding: 20px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); max-height: 90vh; overflow-y: auto;">
        <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 id="metier-modal-title" style="color: white; margin: 0; font-size: 22px;">Nouveau Métier</h2>
            <button onclick="closeModal('metier-modal')" style="background: transparent; border: none; color: white; font-size: 18px; cursor: pointer;">
                &times;
            </button>
        </div>
        <div class="modal-body" style="margin-top: 15px;">
            <form id="metier-form">
                <div style="margin-bottom: 15px;">
                    <label for="metier-nom" style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Nom du Métier</label>
                    <input type="text" id="metier-nom" required 
                        style="width: 100%; padding: 12px 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; color: white; font-size: 14px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="metier-description" style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Description</label>
                    <textarea id="metier-description" rows="3" 
                        style="width: 100%; padding: 12px 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; color: white; font-size: 14px;"></textarea>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Icône</label>
                    <div class="icon-select" style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <div class="icon-selector" data-icon="🔧" style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease;">
                            <span style="font-size: 24px;">🔧</span>
                        </div>
                        <div class="icon-selector" data-icon="💼" style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease;">
                            <span style="font-size: 24px;">💼</span>
                        </div>
                        <div class="icon-selector" data-icon="📊" style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease;">
                            <span style="font-size: 24px;">📊</span>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="metier-icon" value="🔧">
                <button type="submit" id="metier-submit" 
                    style="width: 100%; padding: 12px 0; background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600;">
                    <span id="metier-submit-text">Créer</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Salarié Modal -->
<div id="salarie-modal" class="modal" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 2000; backdrop-filter: blur(8px);">
    <div class="modal-content" style="max-width: 600px; margin: 100px auto; background: rgba(30, 41, 59, 0.9); border-radius: 12px; padding: 20px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); max-height: 90vh; overflow-y: auto;">
        <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 id="salarie-modal-title" style="color: white; margin: 0; font-size: 22px;">Nouveau Salarié</h2>
            <button onclick="closeModal('salarie-modal')" style="background: transparent; border: none; color: white; font-size: 18px; cursor: pointer;">
                &times;
            </button>
        </div>
        <div class="modal-body" style="margin-top: 15px;">
            <form id="salarie-form">
                <div style="margin-bottom: 15px;">
                    <label for="salarie-prenom" style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Prénom</label>
                    <input type="text" id="salarie-prenom" required 
                        style="width: 100%; padding: 12px 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; color: white; font-size: 14px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="salarie-nom" style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Nom</label>
                    <input type="text" id="salarie-nom" required 
                        style="width: 100%; padding: 12px 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; color: white; font-size: 14px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="salarie-email" style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Email</label>
                    <input type="email" id="salarie-email" required 
                        style="width: 100%; padding: 12px 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; color: white; font-size: 14px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="salarie-metier" style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Métier</label>
                    <select id="salarie-metier" required 
                        style="width: 100%; padding: 12px 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; color: white;">
                        <option value="">Sélectionnez un métier</option>
                        @foreach($metiers as $metier)
        <option value="{{ $metier->id }}">{{ $metier->nom }}</option>
    @endforeach
</select>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="salarie-telephone" style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Téléphone</label>
                    <input type="text" id="salarie-telephone" required 
                        style="width: 100%; padding: 12px 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; color: white; font-size: 14px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="salarie-date-embauche" style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Date d'embauche</label>
                    <input type="date" id="salarie-date-embauche" required 
                        style="width: 100%; padding: 12px 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; color: white; font-size: 14px;">
                </div>
                <button type="submit" id="salarie-submit" 
                    style="width: 100%; padding: 12px 0; background: linear-gradient(135deg, #34d399 0%, #10b981 100%); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600;">
                    <span id="salarie-submit-text">Créer</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Groupe Modal -->
<div id="groupe-modal" class="modal" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 2000; backdrop-filter: blur(8px);">
    <div class="modal-content"
         style="max-width: 600px; margin: 100px auto; background: rgba(30, 41, 59, 0.9); border-radius: 12px; padding: 20px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); max-height: 90vh; overflow-y: auto;">
        <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 id="groupe-modal-title" style="color: white; margin: 0; font-size: 22px;">Nouveau Groupe</h2>
            <button onclick="closeModal('groupe-modal')" style="background: transparent; border: none; color: white; font-size: 18px; cursor: pointer;">
                &times;
            </button>
        </div>
        <div class="modal-body" style="margin-top: 15px;">
            <form id="groupe-form">
                <div style="margin-bottom: 15px;">
                    <label for="groupe-nom" style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Nom du Groupe</label>
                    <input type="text" id="groupe-nom" required 
                        style="width: 100%; padding: 12px 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; color: white; font-size: 14px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="groupe-description" style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Description</label>
                    <textarea id="groupe-description" rows="3" 
                        style="width: 100%; padding: 12px 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; color: white; font-size: 14px;"></textarea>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px; display: block;">Membres</label>
                    <div id="available-membres" style="max-height: 200px; overflow-y: auto; background: rgba(255, 255, 255, 0.05); border-radius: 10px; padding: 10px;">
                        @foreach($salaries as $salarie)
                        <div class="membre-option" style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 8px; cursor: pointer; transition: background 0.3s ease;">
                            <input type="checkbox" value="{{ $salarie->id }}" style="transform: scale(1.2); cursor: pointer;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; font-weight: 600;">
                                    {{ strtoupper(substr($salarie->prenom,0,1)) }}{{ strtoupper(substr($salarie->nom,0,1)) }}
                                </div>
                                <span style="color: white; font-size: 14px;">{{ $salarie->prenom }} {{ $salarie->nom }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="selected-list" style="margin-top: 10px; display: flex; flex-direction: column; gap: 8px;">
                        {{-- Selected members will be displayed here --}}
                    </div>
                    <div style="margin-top: 5px; color: rgba(255, 255, 255, 0.7); font-size: 12px;">
                        <span id="selected-count">0</span> membre(s) sélectionné(s)
                    </div>
                </div>
                <button type="submit" id="groupe-submit" 
                    style="width: 100%; padding: 12px 0; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600;">
                    <span id="groupe-submit-text">Créer</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Import Modal -->
<div id="bulk-import-modal" class="modal" class="modal" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 2000; backdrop-filter: blur(8px);">
    <div class="modal-content" style="max-width: 500px; margin: 100px auto; background: rgba(30, 41, 59, 0.9); border-radius: 12px; padding: 20px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);">
        <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="color: white; margin: 0; font-size: 22px;">Importation en Lot</h2>
            <button onclick="closeModal('bulk-import-modal')" style="background: transparent; border: none; color: white; font-size: 18px; cursor: pointer;">
                &times;
            </button>
        </div>
        <div class="modal-body" style="margin-top: 15px;">
            <p style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 15px;">
                Téléchargez le modèle CSV pour importer vos salariés en lot. Assurez-vous que les données sont correctes avant l'importation.
            </p>
            <button onclick="downloadTemplate()" 
                style="width: 100%; padding: 12px 0; background: linear-gradient(135deg, #34d399 0%, #10b981 100%); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600;">
                Télécharger le Modèle
            </button>
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
    });

    // Remove active class and reset style from all tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
        btn.style.background = 'transparent';
        btn.style.color = 'rgba(255, 255, 255, 0.7)';
    });

    // Show selected tab
    document.getElementById(tabName + '-tab').style.display = 'block';

    // Set active style for clicked button
    const btns = document.querySelectorAll('.tab-btn');
    btns.forEach(btn => {
        if (btn.textContent.toLowerCase().includes(tabName)) {
            btn.classList.add('active');
            btn.style.background = 'linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%)';
            btn.style.color = 'white';
        }
    });
}

// Set default tab on page load
document.addEventListener('DOMContentLoaded', function() {
    switchTab('metiers');
});

let currentEditingMetierId = null;
let currentEditingSalarieId = null;
let currentEditingGroupeId = null;

// Open modal by ID
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
    document.body.style.overflow = 'hidden';
}

// Close modal by ID and reset form
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    document.body.style.overflow = 'auto';
    resetForm(modalId);
}

// Reset form fields and modal state
function resetForm(modalId) {
    const form = document.querySelector(`#${modalId} form`);
    if (form) {
        form.reset();
        currentEditingId = null;

        // Métier modal reset
        if (modalId === 'metier-modal') {
            document.getElementById('metier-modal-title').textContent = 'Nouveau Métier';
            document.getElementById('metier-submit-text').textContent = 'Créer';
            // Reset icon selection
            document.querySelectorAll('.icon-selector').forEach(btn => {
                btn.style.background = 'rgba(255, 255, 255, 0.1)';
                btn.style.borderColor = 'transparent';
            });
            const defaultIcon = document.querySelector('.icon-selector[data-icon="🔧"]');
            if (defaultIcon) {
                defaultIcon.style.background = 'rgba(59, 130, 246, 0.3)';
                defaultIcon.style.borderColor = '#3b82f6';
            }
            document.getElementById('metier-icon').value = '🔧';
        }

        // Salarié modal reset
        if (modalId === 'salarie-modal') {
            document.getElementById('salarie-modal-title').textContent = 'Nouveau Salarié';
            document.getElementById('salarie-submit-text').textContent = 'Créer';
        }

        // Groupe modal reset
        if (modalId === 'groupe-modal') {
            document.getElementById('groupe-modal-title').textContent = 'Nouveau Groupe';
            document.getElementById('groupe-submit-text').textContent = 'Créer';
            updateSelectedMembers();
        }
    }
}

// Métier Modal Functions
function openMetierModal() {
    currentEditingMetierId = null;
    openModal('metier-modal');
}
function editMetier(btn) {
    currentEditingMetierId = btn.getAttribute('data-id');
    openModal('metier-modal');
    document.getElementById('metier-modal-title').textContent = 'Modifier le Métier';
    document.getElementById('metier-submit-text').textContent = 'Mettre à jour';

    document.getElementById('metier-nom').value = btn.getAttribute('data-nom') || '';
    document.getElementById('metier-description').value = btn.getAttribute('data-description') || '';
    selectIcon(btn.getAttribute('data-icon') || '🔧');
}
function selectIcon(icon) {
    document.querySelectorAll('.icon-selector').forEach(btn => {
        btn.style.background = 'rgba(255, 255, 255, 0.1)';
        btn.style.borderColor = 'transparent';
    });
    const selected = document.querySelector(`.icon-selector[data-icon="${icon}"]`);
    if (selected) {
        selected.style.background = 'rgba(59, 130, 246, 0.3)';
        selected.style.borderColor = '#3b82f6';
    }
    document.getElementById('metier-icon').value = icon;
}
document.querySelectorAll('.icon-selector').forEach(btn => {
    btn.addEventListener('click', function() {
        selectIcon(this.dataset.icon);
    });
});

// Salarié Modal Functions
function openSalarieModal() {
    currentEditingSalarieId = null;
    openModal('salarie-modal');
}
function editSalarie(btn) {
    currentEditingSalarieId = btn.getAttribute('data-id');
    openModal('salarie-modal');
    document.getElementById('salarie-modal-title').textContent = 'Modifier le Salarié';
    document.getElementById('salarie-submit-text').textContent = 'Mettre à jour';

    document.getElementById('salarie-prenom').value = btn.getAttribute('data-prenom') || '';
    document.getElementById('salarie-nom').value = btn.getAttribute('data-nom') || '';
    document.getElementById('salarie-email').value = btn.getAttribute('data-email') || '';
    document.getElementById('salarie-metier').value = btn.getAttribute('data-metier_id') || '';
    document.getElementById('salarie-telephone').value = btn.getAttribute('data-telephone') || '';
    document.getElementById('salarie-date-embauche').value = btn.getAttribute('data-date_embauche') || '';
}

// Groupe Modal Functions
function openGroupeModal() {
    currentEditingGroupeId = null;
    openModal('groupe-modal');
    updateSelectedMembers();
}
function editGroupe(btn) {
    currentEditingGroupeId = btn.getAttribute('data-id');
    openModal('groupe-modal');
    document.getElementById('groupe-modal-title').textContent = 'Modifier le Groupe';
    document.getElementById('groupe-submit-text').textContent = 'Mettre à jour';

    document.getElementById('groupe-nom').value = btn.getAttribute('data-nom') || '';
    document.getElementById('groupe-description').value = btn.getAttribute('data-description') || '';

    // Cocher les bons membres
    const membres = (btn.getAttribute('data-membres') || '').split(',').filter(Boolean);
    document.querySelectorAll('#available-membres input[type="checkbox"]').forEach(cb => {
        cb.checked = membres.includes(cb.value);
    });
    updateSelectedMembers();
}

// Update selected members list in groupe modal
function updateSelectedMembers() {
    const selected = Array.from(document.querySelectorAll('#available-membres input[type="checkbox"]:checked'));
    const selectedList = document.getElementById('selected-list');
    const selectedCount = document.getElementById('selected-count');
    selectedList.innerHTML = '';
    selected.forEach(cb => {
        const label = cb.parentElement.querySelector('div + div > div')?.textContent || cb.parentElement.querySelector('div')?.textContent || '';
        const avatar = cb.parentElement.querySelector('div[style*="background"]');
        selectedList.innerHTML += `<div style="display: flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.1); padding: 6px 10px; border-radius: 16px;">
            ${avatar ? avatar.outerHTML : ''}<span>${label}</span>
        </div>`;
    });
    selectedCount.textContent = selected.length;
}
document.querySelectorAll('#available-membres input[type="checkbox"]').forEach(cb => {
    cb.addEventListener('change', updateSelectedMembers);
});

// Search membres in groupe modal
document.getElementById('membre-search')?.addEventListener('input', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('#available-membres .membre-option').forEach(opt => {
        const text = opt.textContent.toLowerCase();
        opt.style.display = text.includes(term) ? 'flex' : 'none';
    });
});

// Bulk Import Modal
function bulkImport() {
    openModal('bulk-import-modal');
}
function downloadTemplate() {
    // Simulate download
    alert('Téléchargement du modèle CSV...');
}

// Close modals on background click
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal(modal.id);
    });
});

document.getElementById('metier-form').onsubmit = async function(e) {
    e.preventDefault();
    const id = currentEditingMetierId;
    const isEdit = !!id;
    const url = isEdit ? `/metiers/${id}` : '/metiers';
    const data = {
        nom: document.getElementById('metier-nom').value,
        description: document.getElementById('metier-description').value,
        icon: document.getElementById('metier-icon').value,
        _token: csrfToken
    };
    if (isEdit) data._method = 'PUT';

    const res = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    });
    if (res.ok) {
        closeModal('metier-modal');
        location.reload();
    } else {
        alert('Erreur lors de la sauvegarde du métier');
    }
};

document.getElementById('salarie-form').onsubmit = async function(e) {
    e.preventDefault();
    const id = currentEditingSalarieId;
    const isEdit = !!id;
    const url = isEdit ? `/salaries/${id}` : '/salaries';
    const data = {
        prenom: document.getElementById('salarie-prenom').value,
        nom: document.getElementById('salarie-nom').value,
        email: document.getElementById('salarie-email').value,
        metier_id: document.getElementById('salarie-metier').value,
        telephone: document.getElementById('salarie-telephone').value,
        date_embauche: document.getElementById('salarie-date-embauche').value,
        _token: csrfToken
    };
    if (isEdit) data._method = 'PUT';

    const res = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    });
    if (res.ok) {
        closeModal('salarie-modal');
        location.reload();
    } else {
        alert('Erreur lors de la sauvegarde du salarié');
    }
};

document.getElementById('groupe-form').onsubmit = async function(e) {
    e.preventDefault();
    const id = currentEditingGroupeId;
    const isEdit = !!id;
    const url = isEdit ? `/groupes/${id}` : '/groupes';
    const nom = document.getElementById('groupe-nom').value;
    const description = document.getElementById('groupe-description').value;
    const membres = Array.from(document.querySelectorAll('#available-membres input[type="checkbox"]:checked')).map(cb => cb.value);

    const data = {
        nom,
        description,
        membres,
        _token: csrfToken
    };
    if (isEdit) data._method = 'PUT';

    const res = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    });
    if (res.ok) {
        closeModal('groupe-modal');
        location.reload();
    } else {
        alert('Erreur lors de la sauvegarde du groupe');
    }
};

document.getElementById('salarie-search').addEventListener('input', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.salarie-item').forEach(item => {
        const search = item.getAttribute('data-search');
        item.style.display = search.includes(term) ? 'flex' : 'none';
    });
});

document.getElementById('filter-metier').addEventListener('change', function() {
    const metierId = this.value;
    document.querySelectorAll('.salarie-item').forEach(item => {
        const itemMetier = item.querySelector('button.edit-salarie-btn').getAttribute('data-metier_id');
        if (!metierId || itemMetier === metierId) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>
</x-app-layout>