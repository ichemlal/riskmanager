<x-app-layout>
    <style>
        .cancel-container {
            max-width: 600px;
            margin: 100px auto;
            text-align: center;
            padding: 40px;
        }

        .cancel-icon {
            font-size: 80px;
            color: #f59e0b;
            margin-bottom: 30px;
        }

        .cancel-title {
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
        }

        .cancel-message {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .cancel-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cancel-button {
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .cancel-button.primary {
            background: linear-gradient(135deg, #8b44ff, #3b82f6);
            color: white;
        }

        .cancel-button.primary:hover {
            background: linear-gradient(135deg, #7c3aed, #2563eb);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(139, 68, 255, 0.4);
            text-decoration: none;
            color: white;
        }

        .cancel-button.secondary {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .cancel-button.secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
        }
    </style>

    <div class="cancel-container">
        <div class="cancel-icon">⚠️</div>
        <h1 class="cancel-title">Paiement annulé</h1>
        <p class="cancel-message">
            Votre processus de paiement a été annulé. Aucun montant n'a été débité. 
            Vous pouvez essayer à nouveau ou choisir un autre plan.
        </p>
        <div class="cancel-buttons">
            <a href="{{ route('pricing') }}" class="cancel-button primary">
                Choisir un plan
            </a>
            <a href="{{ route('dashboard') }}" class="cancel-button secondary">
                Retour au tableau de bord
            </a>
        </div>
    </div>
</x-app-layout>
