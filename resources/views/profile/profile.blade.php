<x-app-layout>
    <style>
        .profile-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .profile-header {
            background: linear-gradient(135deg, rgba(139, 68, 255, 0.1), rgba(59, 130, 246, 0.1));
            border: 1px solid rgba(139, 68, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: 700;
            margin: 0 auto 20px;
            border: 4px solid rgba(139, 68, 255, 0.3);
            box-shadow: 0 20px 40px rgba(139, 68, 255, 0.3);
            transition: all 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 25px 50px rgba(139, 68, 255, 0.5);
        }

        .profile-name {
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin: 0 0 10px 0;
            text-shadow: 0 2px 10px rgba(139, 68, 255, 0.3);
        }

        .profile-email {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
            margin: 0 0 15px 0;
        }

        .profile-role {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .role-admin {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .role-referent {
            background: rgba(139, 68, 255, 0.2);
            color: #8b44ff;
            border: 1px solid rgba(139, 68, 255, 0.3);
        }

        .role-employer {
            background: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .role-user {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .profile-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .profile-form-card,
        .profile-info-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.3s ease;
        }

        .profile-form-card:hover,
        .profile-info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 68, 255, 0.2);
        }

        .card-title {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 15px 18px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #8b44ff;
            box-shadow: 0 0 20px rgba(139, 68, 255, 0.3);
            background: rgba(139, 68, 255, 0.05);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-width: 150px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(139, 68, 255, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            font-weight: 500;
        }

        .info-value {
            color: white;
            font-weight: 600;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            margin-top: 25px;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #8b44ff;
            margin-bottom: 5px;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }

        @media (max-width: 768px) {
            .profile-content {
                grid-template-columns: 1fr;
            }
            
            .profile-header {
                padding: 30px 20px;
            }
            
            .profile-avatar {
                width: 100px;
                height: 100px;
                font-size: 40px;
            }
            
            .profile-name {
                font-size: 24px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-container > * {
            animation: fadeInUp 0.6s ease-out;
        }

        .profile-content > *:nth-child(2) {
            animation-delay: 0.2s;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mon Profil') }}
        </h2>
    </x-slot>

    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <h1 class="profile-name">{{ auth()->user()->name }}</h1>
            <p class="profile-email">{{ auth()->user()->email }}</p>
            <div class="profile-role 
                @if(auth()->user()->hasRole('admin'))
                    role-admin
                @elseif(auth()->user()->hasRole('referent'))
                    role-referent
                @elseif(auth()->user()->hasRole('employer'))
                    role-employer
                @else
                    role-user
                @endif
            ">
                @if(auth()->user()->hasRole('admin'))
                    👑 Administrateur
                @elseif(auth()->user()->hasRole('referent'))
                    🎯 Référent DUERP
                @elseif(auth()->user()->hasRole('employer'))
                    👤 Employé
                @else
                    🔧 Utilisateur
                @endif
            </div>
        </div>

        <!-- Profile Content -->
        <div class="profile-content">
            <!-- Edit Form -->
            <div class="profile-form-card">
                <h2 class="card-title">
                    ✏️ Modifier mes informations
                </h2>

                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success">
                        ✅ Profil mis à jour avec succès !
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        ❌ Veuillez corriger les erreurs ci-dessous
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    
                    <div class="form-group">
                        <label for="name" class="form-label">Nom complet</label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            value="{{ old('name', auth()->user()->name) }}"
                            class="form-input"
                            placeholder="Votre nom complet"
                            required
                        >
                        @error('name')
                            <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Adresse email</label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            value="{{ old('email', auth()->user()->email) }}"
                            class="form-input"
                            placeholder="votre.email@example.com"
                            required
                        >
                        @error('email')
                            <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="btn btn-primary">
                            💾 Sauvegarder
                        </button>
                        <a href="{{ route('profile.edit') }}" class="btn btn-secondary">
                            🔒 Changer le mot de passe
                        </a>
                    </div>
                </form>
            </div>

            <!-- Profile Info -->
            <div class="profile-info-card">
                <h2 class="card-title">
                    📊 Informations du compte
                </h2>

                <div class="info-item">
                    <span class="info-label">Membre depuis</span>
                    <span class="info-value">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Dernière connexion</span>
                    <span class="info-value">{{ auth()->user()->updated_at->format('d/m/Y H:i') }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Statut du compte</span>
                    <span class="info-value" style="color: #22c55e;">✅ Actif</span>
                </div>

                <div class="info-item">
                    <span class="info-label">ID Utilisateur</span>
                    <span class="info-value">#{{ auth()->user()->id }}</span>
                </div>

                <!-- Quick Stats -->
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">{{ auth()->user()->hasRole('referent') ? '🎯' : (auth()->user()->hasRole('admin') ? '👑' : '👤') }}</div>
                        <div class="stat-label">Rôle</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">🔐</div>
                        <div class="stat-label">Sécurisé</div>
                    </div>
                    @if(auth()->user()->hasRole('referent') || auth()->user()->hasRole('employer'))
                        <div class="stat-item">
                            <div class="stat-value">📋</div>
                            <div class="stat-label">DUERP</div>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div style="margin-top: 30px;">
                    <h3 style="color: rgba(255, 255, 255, 0.9); font-size: 16px; margin-bottom: 15px;">Actions rapides</h3>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @if(auth()->user()->hasRole('referent'))
                            <a href="{{ route('questions.campaigns') }}" class="btn btn-secondary" style="justify-content: flex-start;">
                                📊 Voir mes résultats
                            </a>
                        @elseif(auth()->user()->hasRole('employer'))
                            <a href="{{ route('quiz') }}" class="btn btn-secondary" style="justify-content: flex-start;">
                                📋 Mes campagnes
                            </a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="justify-content: flex-start;">
                            🏠 Tableau de bord
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>