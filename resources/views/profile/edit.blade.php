<x-app-layout>
    <style>
        .profile-edit-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .profile-edit-header {
            background: linear-gradient(135deg, rgba(139, 68, 255, 0.1), rgba(59, 130, 246, 0.1));
            border: 1px solid rgba(139, 68, 255, 0.2);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        .edit-title {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
        }

        .edit-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
        }

        .edit-sections {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .edit-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 30px;
            transition: all 0.3s ease;
        }

        .edit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 68, 255, 0.2);
        }

        .card-title {
            font-size: 20px;
            font-weight: 600;
            color: white;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
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

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .back-button {
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .profile-edit-container {
                padding: 15px;
            }
            
            .edit-card {
                padding: 20px;
            }
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier le Profil') }}
        </h2>
    </x-slot>

    <div class="profile-edit-container">
        <!-- Back Button -->
        <div class="back-button">
            <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                ← Retour au profil
            </a>
        </div>

        <!-- Header -->
        <div class="profile-edit-header">
            <h1 class="edit-title">⚙️ Paramètres du Profil</h1>
            <p class="edit-subtitle">Gérez vos informations personnelles et la sécurité de votre compte</p>
        </div>

        <!-- Edit Sections -->
        <div class="edit-sections">
            <!-- Profile Information -->
            <div class="edit-card">
                <h2 class="card-title">
                    📝 Informations du Profil
                </h2>
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Password Update -->
            <div class="edit-card">
                <h2 class="card-title">
                    🔐 Modifier le Mot de Passe
                </h2>
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete Account -->
            <div class="edit-card" style="border-color: rgba(239, 68, 68, 0.3);">
                <h2 class="card-title" style="color: #ef4444;">
                    🗑️ Zone Dangereuse
                </h2>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
