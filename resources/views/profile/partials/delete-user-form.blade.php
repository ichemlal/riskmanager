<div style="color: rgba(255, 255, 255, 0.8); margin-bottom: 25px;">
    Une fois votre compte supprimé, toutes ses données seront définitivement perdues. Veuillez télécharger toutes les informations importantes avant de continuer.
</div>

<button 
    onclick="document.getElementById('deleteModal').style.display = 'flex'"
    class="btn"
    style="background: linear-gradient(135deg, #e53e3e, #c53030); color: white; font-weight: 500;"
>
    🗑️ Supprimer le compte
</button>

<!-- Modal de confirmation -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); border-radius: 20px; padding: 30px; max-width: 500px; width: 90%; border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
        <h3 style="color: white; font-size: 20px; font-weight: 600; margin-bottom: 15px; text-align: center;">
            ⚠️ Êtes-vous sûr de vouloir supprimer votre compte ?
        </h3>
        
        <p style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 25px; text-align: center; line-height: 1.5;">
            Cette action est irréversible. Toutes vos données et ressources seront définitivement supprimées. Veuillez entrer votre mot de passe pour confirmer.
        </p>

        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="form-group" style="margin-bottom: 25px;">
                <input 
                    id="password"
                    name="password"
                    type="password"
                    class="form-input"
                    placeholder="Votre mot de passe"
                    required
                    style="width: 100%;"
                />
                @error('password')
                    <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <button 
                    type="button"
                    onclick="document.getElementById('deleteModal').style.display = 'none'"
                    class="btn btn-secondary"
                >
                    Annuler
                </button>

                <button 
                    type="submit"
                    class="btn"
                    style="background: linear-gradient(135deg, #e53e3e, #c53030); color: white; font-weight: 500;"
                >
                    🗑️ Supprimer définitivement
                </button>
            </div>
        </form>
    </div>
</div>
