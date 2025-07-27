<div style="color: rgba(255, 255, 255, 0.8); margin-bottom: 25px;">
    Mettez à jour les informations de votre compte et votre adresse email.
</div>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="form-group">
        <label for="name" class="form-label">Nom Complet</label>
        <input 
            id="name" 
            name="name" 
            type="text" 
            class="form-input" 
            value="{{ old('name', $user->name) }}" 
            required 
            autofocus 
            autocomplete="name"
            placeholder="Votre nom complet"
        />
        @error('name')
            <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email" class="form-label">Adresse Email</label>
        <input 
            id="email" 
            name="email" 
            type="email" 
            class="form-input" 
            value="{{ old('email', $user->email) }}" 
            required 
            autocomplete="username"
            placeholder="votre.email@example.com"
        />
        @error('email')
            <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div style="margin-top: 10px;">
                <p style="color: #f59e0b; font-size: 14px; margin-bottom: 10px;">
                    ⚠️ Votre adresse email n'est pas vérifiée.
                </p>
                <button form="send-verification" class="btn btn-secondary" style="font-size: 12px; padding: 8px 16px;">
                    📧 Renvoyer l'email de vérification
                </button>

                @if (session('status') === 'verification-link-sent')
                    <p style="color: #22c55e; font-size: 12px; margin-top: 8px;">
                        ✅ Un nouveau lien de vérification a été envoyé à votre adresse email.
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div style="display: flex; align-items: center; gap: 15px; margin-top: 25px;">
        <button type="submit" class="btn btn-primary">
            💾 Enregistrer
        </button>

        @if (session('status') === 'profile-updated')
            <span style="color: #22c55e; font-size: 14px;">
                ✅ Sauvegardé !
            </span>
        @endif
    </div>
</form>
