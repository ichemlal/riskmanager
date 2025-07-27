<x-app-layout>
    <style>
        .pricing-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .pricing-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .pricing-title {
            font-size: 42px;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
        }

        .pricing-subtitle {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.7);
            max-width: 600px;
            margin: 0 auto;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .pricing-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px 30px;
            position: relative;
            transition: all 0.3s ease;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(139, 68, 255, 0.3);
        }

        .pricing-card.popular {
            border-color: rgba(139, 68, 255, 0.5);
            background: rgba(139, 68, 255, 0.1);
        }

        .popular-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #8b44ff, #3b82f6);
            color: white;
            padding: 8px 24px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .plan-name {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
        }

        .plan-price {
            font-size: 48px;
            font-weight: 700;
            color: #60a5fa;
            margin-bottom: 5px;
        }

        .plan-currency {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.7);
        }

        .plan-period {
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 30px;
        }

        .plan-features {
            list-style: none;
            padding: 0;
            margin: 30px 0;
        }

        .plan-features li {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 15px;
            font-size: 16px;
        }

        .plan-features li::before {
            content: "✓";
            color: #10b981;
            font-weight: bold;
            margin-right: 12px;
            font-size: 18px;
        }

        .plan-button {
            width: 100%;
            background: linear-gradient(135deg, #8b44ff, #3b82f6);
            color: white;
            border: none;
            padding: 16px 24px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .plan-button:hover {
            background: linear-gradient(135deg, #7c3aed, #2563eb);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(139, 68, 255, 0.4);
            text-decoration: none;
            color: white;
        }

        .plan-button.secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .plan-button.secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .guarantee {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 40px;
            font-size: 14px;
        }

        .guarantee-icon {
            display: inline-block;
            margin-right: 8px;
            color: #10b981;
        }
    </style>

    <div class="pricing-container">
        <!-- Header -->
        <div class="pricing-header">
            <h1 class="pricing-title">Choisissez votre plan</h1>
            <p class="pricing-subtitle">
                Sélectionnez le plan qui correspond le mieux aux besoins de votre entreprise. 
                Tous les plans incluent une période d'essai gratuite de 14 jours.
            </p>
        </div>

        <!-- Error Display -->
        @if ($errors->any())
            <div style="background-color: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 15px; border-radius: 10px; margin-bottom: 30px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Pricing Cards -->
        <div class="pricing-grid">
            @foreach($plans as $plan)
                <div class="pricing-card {{ isset($plan['popular']) && $plan['popular'] ? 'popular' : '' }}">
                    @if(isset($plan['popular']) && $plan['popular'])
                        <div class="popular-badge">Plus populaire</div>
                    @endif
                    
                    <h3 class="plan-name">{{ $plan['name'] }}</h3>
                    <div class="plan-price">
                        €{{ number_format($plan['amount'] / 100, 0) }}
                        <span class="plan-currency">/ mois</span>
                    </div>
                    <div class="plan-period">Facturation mensuelle</div>
                    
                    <ul class="plan-features">
                        @foreach($plan['features'] as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                    
                    <form method="POST" action="{{ route('pricing.checkout') }}" onsubmit="console.log('Form submitted with price_id:', this.price_id.value);">
                        @csrf
                        <input type="hidden" name="price_id" value="{{ $plan['price'] }}">
                        <button type="submit" class="plan-button">
                            Commencer l'essai gratuit
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Guarantee -->
        <div class="guarantee">
            <span class="guarantee-icon">🛡️</span>
            Annulation à tout moment • Support client 24/7 • Remboursement sous 30 jours
        </div>
    </div>
</x-app-layout>
