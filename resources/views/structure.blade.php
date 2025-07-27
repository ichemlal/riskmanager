<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Structure') }}
        </h2>
    </x-slot>
<!-- Structure Page Content -->
<!-- Main Content for Structure Page -->
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Configuration Structure</h1>
            <p>Définissez les informations de votre organisation</p>
        </div>


        <!-- Form Container -->
 
        <div class="chart-card" style="max-width: 800px; margin: 0 auto;">
            <h3 style="display: flex; align-items: center; gap: 12px; margin-bottom: 30px;">
                <div class="stat-icon purple" style="width: 32px; height: 32px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 21h18"/>
                        <path d="M5 21V7l8-4v18"/>
                        <path d="M19 21V11l-6-4"/>
                    </svg>
                </div>
                Informations de l'organisation
            </h3>

        <form id="structureForm" method="POST" action="{{ route('save.structure') }}" style="display: grid; gap: 24px;">
    @csrf                <!-- Nom de la structure -->
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="color: white; font-weight: 500; font-size: 14px;">
                        Nom de la structure <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" 
                           id="nom_structure" 
                           name="nom_structure" 
                           required
                           value="{{ old('nom_structure', $structure->nom_structure ?? '') }}"
                           style="padding: 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; color: white; font-size: 16px; transition: all 0.3s ease;"
                           placeholder="Entrez le nom de votre organisation">
                </div>

                <!-- SIRET -->
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="color: white; font-weight: 500; font-size: 14px;">
                        SIRET <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" 
                           id="siret" 
                           name="siret" 
                           required
                           maxlength="14"
                           pattern="[0-9]{14}"
                           value="{{ old('siret', $structure->siret ?? '') }}"
                           style="padding: 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; color: white; font-size: 16px; transition: all 0.3s ease;"
                           placeholder="12345678901234">
                    <small style="color: rgba(255, 255, 255, 0.6); font-size: 12px;">14 chiffres sans espaces</small>
                </div>

                <!-- Adresse -->
                <div style="display: grid; gap: 16px;">
                    <label style="color: white; font-weight: 500; font-size: 14px;">
                        Adresse postale <span style="color: #ef4444;">*</span>
                    </label>
                    
                    <input type="text" 
                           id="adresse" 
                           name="adresse" 
                           required
                           value="{{ old('adresse', $structure->adresse ?? '') }}"
                           style="padding: 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; color: white; font-size: 16px; transition: all 0.3s ease;"
                           placeholder="Adresse complète">
                    
                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 16px;">
                        <input type="text" 
                               id="code_postal" 
                               name="code_postal" 
                               required
                               maxlength="5"
                               pattern="[0-9]{5}"
                               value="{{ old('code_postal', $structure->code_postal ?? '') }}"
                               style="padding: 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; color: white; font-size: 16px; transition: all 0.3s ease;"
                               placeholder="Code postal">
                        
                        <input type="text" 
                               id="ville" 
                               name="ville" 
                               required
                               value="{{ old('ville', $structure->ville ?? '') }}"
                               style="padding: 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; color: white; font-size: 16px; transition: all 0.3s ease;"
                               placeholder="Ville">
                    </div>
                </div>

                <!-- Email de contact -->
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="color: white; font-weight: 500; font-size: 14px;">
                        Email de contact <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="email" 
                           id="email_contact" 
                           name="email_contact" 
                           required
                           value="{{ old('email_contact', $structure->email_contact ?? '') }}"
                           style="padding: 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; color: white; font-size: 16px; transition: all 0.3s ease;"
                           placeholder="contact@entreprise.com">
                </div>

                <!-- Informations supplémentaires -->
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="color: white; font-weight: 500; font-size: 14px;">
                        Secteur d'activité
                    </label>
                    <select id="secteur_activite" 
                            name="secteur_activite"
                            style="padding: 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; color: white; font-size: 16px; transition: all 0.3s ease;">
                        <option value="">Sélectionnez un secteur</option>
                        <option value="industrie" {{ old('secteur_activite', $structure->secteur_activite ?? '') == 'industrie' ? 'selected' : '' }}>Industrie</option>
                        <option value="services" {{ old('secteur_activite', $structure->secteur_activite ?? '') == 'services' ? 'selected' : '' }}>Services</option>
                        <option value="commerce" {{ old('secteur_activite', $structure->secteur_activite ?? '') == 'commerce' ? 'selected' : '' }}>Commerce</option>
                        <option value="batiment" {{ old('secteur_activite', $structure->secteur_activite ?? '') == 'batiment' ? 'selected' : '' }}>Bâtiment et travaux publics</option>
                        <option value="sante" {{ old('secteur_activite', $structure->secteur_activite ?? '') == 'sante' ? 'selected' : '' }}>Santé et social</option>
                        <option value="education" {{ old('secteur_activite', $structure->secteur_activite ?? '') == 'education' ? 'selected' : '' }}>Éducation</option>
                        <option value="transport" {{ old('secteur_activite', $structure->secteur_activite ?? '') == 'transport' ? 'selected' : '' }}>Transport et logistique</option>
                        <option value="autre" {{ old('secteur_activite', $structure->secteur_activite ?? '') == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="color: white; font-weight: 500; font-size: 14px;">
                        Nombre d'employés approximatif
                    </label>
                    <select id="nombre_employes" 
                            name="nombre_employes"
                            style="padding: 16px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; color: white; font-size: 16px; transition: all 0.3s ease;">
                        <option value="">Sélectionnez une tranche</option>
                        <option value="1-10" {{ old('nombre_employes', $structure->nombre_employes ?? '') == '1-10' ? 'selected' : '' }}>1 à 10 employés</option>
                        <option value="11-50" {{ old('nombre_employes', $structure->nombre_employes ?? '') == '11-50' ? 'selected' : '' }}>11 à 50 employés</option>
                        <option value="51-200" {{ old('nombre_employes', $structure->nombre_employes ?? '') == '51-200' ? 'selected' : '' }}>51 à 200 employés</option>
                        <option value="201-500" {{ old('nombre_employes', $structure->nombre_employes ?? '') == '201-500' ? 'selected' : '' }}>201 à 500 employés</option>
                        <option value="500+" {{ old('nombre_employes', $structure->nombre_employes ?? '') == '500+' ? 'selected' : '' }}>Plus de 500 employés</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 16px; justify-content: flex-end; margin-top: 20px;">
                    <button type="button" 
                            style="padding: 16px 24px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; color: white; font-size: 16px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;">
                        Annuler
                    </button>
                    <button type="submit" 
                            style="padding: 16px 32px; background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%); border: none; border-radius: 12px; color: white; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(139, 68, 255, 0.4);">
                            Enregistrer
                        </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="alerts-card" style="margin-top: 40px;">
            <h3>Aide et conseils</h3>
            <div class="alerts-list">
                <div class="alert success">
                    <div class="alert-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M9,12l2,2 4-4"/>
                        </svg>
                    </div>
                    <div class="alert-content">
                        <div class="alert-title">SIRET</div>
                        <div class="alert-description">Le numéro SIRET est composé de 14 chiffres et identifie votre établissement. Vous le trouverez sur vos documents officiels.</div>
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
                        <div class="alert-title">Informations importantes</div>
                        <div class="alert-description">Ces informations seront utilisées pour générer votre Document Unique d'Évaluation des Risques Professionnels (DUERP).</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<style>
/* Additional styles for form elements */
input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: #8b44ff !important;
    box-shadow: 0 0 0 3px rgba(139, 68, 255, 0.2) !important;
}

input:hover, select:hover, textarea:hover {
    border-color: rgba(255, 255, 255, 0.4) !important;
}

button:hover {
    transform: translateY(-2px);
}

button[type="submit"]:hover {
    background: linear-gradient(135deg, #7c22f7 0%, #2563eb 100%) !important;
    box-shadow: 0 12px 30px rgba(139, 68, 255, 0.5) !important;
}

select option {
    background: #1a1a2e;
    color: white;
}

/* Form validation styles */
input:invalid {
    border-color: #ef4444 !important;
}

input:valid {
    border-color: #22c55e !important;
}

@media (min-width: 768px) {
    .form-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .form-group.full-width {
        grid-column: 1 / -1;
    }
}
</style>

<script>
// Form validation and enhancement
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('structureForm');
    const siretInput = document.getElementById('siret');
    const codePostalInput = document.getElementById('code_postal');
    
    // SIRET formatting
    siretInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value.substring(0, 14);
    });
    
    // Code postal formatting
    codePostalInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value.substring(0, 5);
    });
  
});
</script>
</x-app-layout>