<div style="color: rgba(255, 255, 255, 0.8); margin-bottom: 25px;">
    Assurez-vous que votre compte utilise un mot de passe long et sécurisé.
</div>

<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="form-group">
        <label for="update_password_current_password" class="form-label">Mot de passe actuel</label>
        <input 
            id="update_password_current_password" 
            name="current_password" 
            type="password" 
            class="form-input" 
            autocomplete="current-password"
            placeholder="Entrez votre mot de passe actuel"
        />
        @error('current_password')
            <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="update_password_password" class="form-label">Nouveau mot de passe</label>
        <input 
            id="update_password_password" 
            name="password" 
            type="password" 
            class="form-input" 
            autocomplete="new-password"
            placeholder="Entrez votre nouveau mot de passe"
        />
        @error('password')
            <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="update_password_password_confirmation" class="form-label">Confirmer le mot de passe</label>
        <input 
            id="update_password_password_confirmation" 
            name="password_confirmation" 
            type="password" 
            class="form-input" 
            autocomplete="new-password"
            placeholder="Confirmez votre nouveau mot de passe"
        />
        @error('password_confirmation')
            <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div style="display: flex; align-items: center; gap: 15px; margin-top: 25px;">
        <button type="submit" class="btn btn-primary">
            🔐 Mettre à jour le mot de passe
        </button>

        @if (session('status') === 'password-updated')
            <span style="color: #22c55e; font-size: 14px;">
                ✅ Mot de passe mis à jour !
            </span>
        @endif
    </div>
</form>
