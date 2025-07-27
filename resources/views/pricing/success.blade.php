<x-app-layout>
    <style>
        .success-container {
            max-width: 600px;
            margin: 100px auto;
            text-align: center;
            padding: 40px;
        }

        .success-icon {
            font-size: 80px;
            color: #10b981;
            margin-bottom: 30px;
        }

        .success-title {
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
        }

        .success-message {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .success-button {
            background: linear-gradient(135deg, #8b44ff, #3b82f6);
            color: white;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .success-button:hover {
            background: linear-gradient(135deg, #7c3aed, #2563eb);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(139, 68, 255, 0.4);
            text-decoration: none;
            color: white;
        }
    </style>

    <div class="success-container">
        <div class="success-icon">✅</div>
        <h1 class="success-title">Paiement réussi !</h1>
        <p class="success-message">
            Félicitations ! Votre abonnement a été activé avec succès. 
            Vous pouvez maintenant accéder à toutes les fonctionnalités de votre plan.
        </p>
        <a href="{{ route('dashboard') }}" class="success-button">
            Accéder au tableau de bord
        </a>
    </div>
</x-app-layout>
