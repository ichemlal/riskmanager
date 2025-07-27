<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RiskManager - Gestion des Risques Professionnels</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .header.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: #6366f1;
            text-decoration: none;
        }

        .logo i {
            margin-right: 0.5rem;
            font-size: 1.8rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #64748b;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #6366f1;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .btn-secondary {
            background: #fff;
            color: #64748b;
            border: 2px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #f8fafc;
            color: #6366f1;
            border-color: #6366f1;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8rem 2rem 6rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="50" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="30" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        /* Features Section */
        .features {
            padding: 6rem 2rem;
            background: #f8fafc;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .section-header p {
            font-size: 1.1rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: white;
            font-size: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: #64748b;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats {
            padding: 6rem 2rem;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }

        .stat-item {
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: #60a5fa;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Pricing Section */
        .pricing {
            padding: 6rem 2rem;
            background: white;
        }

        .pricing-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .pricing-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            position: relative;
            transition: all 0.3s ease;
        }

        .pricing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .pricing-card.popular {
            border-color: #6366f1;
            transform: scale(1.05);
        }

        .popular-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .pricing-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .price {
            margin-bottom: 2rem;
        }

        .price .currency {
            font-size: 1.25rem;
            color: #64748b;
        }

        .price .amount {
            font-size: 3rem;
            font-weight: 800;
            color: #1e293b;
        }

        .price .period {
            font-size: 1rem;
            color: #64748b;
        }

        .pricing-features {
            list-style: none;
            margin-bottom: 2rem;
        }

        .pricing-features li {
            padding: 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .pricing-features i {
            color: #22c55e;
            width: 16px;
        }

        /* About Section */
        .about {
            padding: 6rem 2rem;
            background: #f8fafc;
        }

        .about-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-text h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.5rem;
        }

        .about-text p {
            font-size: 1.1rem;
            color: #64748b;
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }

        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 2rem;
        }

        .about-stat h3 {
            font-size: 2rem;
            font-weight: 800;
            color: #6366f1;
            margin-bottom: 0.5rem;
        }

        .about-stat p {
            color: #64748b;
            font-size: 0.9rem;
            margin: 0;
        }

        .about-image {
            display: grid;
            gap: 1.5rem;
        }

        .about-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .about-card i {
            font-size: 2rem;
            color: #6366f1;
            margin-bottom: 1rem;
        }

        .about-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .about-card p {
            color: #64748b;
            margin: 0;
        }

        /* Contact Section */
        .contact {
            padding: 6rem 2rem;
            background: white;
        }

        .contact-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            margin-top: 3rem;
        }

        .contact-info {
            display: grid;
            gap: 1.5rem;
        }

        .contact-card {
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: white;
            font-size: 1.25rem;
        }

        .contact-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .contact-card p {
            color: #64748b;
            margin: 0.25rem 0;
        }

        .contact-form {
            background: #f8fafc;
            padding: 2rem;
            border-radius: 16px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #6366f1;
        }

        .form-group textarea {
            resize: vertical;
        }

        /* CTA Section */
        .cta {
            padding: 6rem 2rem;
            background: white;
            text-align: center;
        }

        .cta-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .cta h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .cta p {
            font-size: 1.1rem;
            color: #64748b;
            margin-bottom: 2rem;
        }

        /* Footer */
        .footer {
            background: #1e293b;
            color: white;
            padding: 3rem 2rem 2rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #60a5fa;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section ul li a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section ul li a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid #334155;
            padding-top: 2rem;
            text-align: center;
            color: #94a3b8;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .pricing-grid {
                grid-template-columns: 1fr;
            }

            .pricing-card.popular {
                transform: none;
            }

            .about-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .about-stats {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .contact-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
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

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <nav class="nav">
            <a href="/" class="logo">
                <i class="fas fa-shield-alt"></i>
                RiskManager
            </a>
            
            <ul class="nav-links">
                <li><a href="#features">Fonctionnalités</a></li>
                <li><a href="#pricing">Tarifs</a></li>
                <li><a href="#about">À propos</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            
            <div class="auth-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-rocket"></i>
                            Commencer
                        </a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content animate-fade-in-up">
            <h1>Gérez les Risques Professionnels avec Simplicité</h1>
            <p>
                Plateforme complète pour l'évaluation, le suivi et la prévention des risques 
                en entreprise. Protégez vos employés et respectez la réglementation.
            </p>
            <div class="hero-buttons">
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-play"></i>
                        Essai Gratuit 14 jours
                    </a>
                    <a href="#features" class="btn btn-secondary">
                        <i class="fas fa-info-circle"></i>
                        Découvrir
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-tachometer-alt"></i>
                        Accéder au Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="features-container">
            <div class="section-header">
                <h2>Fonctionnalités Puissantes</h2>
                <p>
                    Tous les outils nécessaires pour une gestion complète des risques professionnels 
                    dans votre entreprise.
                </p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-list-check"></i>
                    </div>
                    <h3>Évaluation des Risques</h3>
                    <p>
                        Créez et gérez des questionnaires personnalisés pour évaluer tous types de risques 
                        professionnels selon vos besoins spécifiques.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Gestion des Équipes</h3>
                    <p>
                        Organisez vos employés par groupes, métiers et structures pour un suivi 
                        personnalisé et efficace des risques.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Analyses Détaillées</h3>
                    <p>
                        Tableaux de bord et rapports complets pour suivre l'évolution des risques 
                        et prendre des décisions éclairées.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>Campagnes Automatisées</h3>
                    <p>
                        Lancez des campagnes d'évaluation automatiques avec notifications 
                        et rappels pour une participation optimale.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-check"></i>
                    </div>
                    <h3>Conformité Réglementaire</h3>
                    <p>
                        Respectez automatiquement les exigences légales avec nos modèles 
                        conformes aux normes en vigueur.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-export"></i>
                    </div>
                    <h3>Exports & Rapports</h3>
                    <p>
                        Générez des rapports PDF et exports Excel pour partager vos résultats 
                        avec les autorités et parties prenantes.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-container">
            <h2>Des Résultats Concrets</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Réduction des Incidents</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Entreprises Clientes</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Employés Protégés</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Support Disponible</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing" id="pricing">
        <div class="pricing-container">
            <div class="section-header">
                <h2>Plans Tarifaires</h2>
                <p>
                    Choisissez le plan qui correspond à vos besoins. Tous les plans incluent 
                    une période d'essai gratuite de 14 jours.
                </p>
            </div>
            
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Starter</h3>
                        <div class="price">
                            <span class="currency">€</span>
                            <span class="amount">29</span>
                            <span class="period">/mois</span>
                        </div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Jusqu'à 50 employés</li>
                        <li><i class="fas fa-check"></i> Campagnes illimitées</li>
                        <li><i class="fas fa-check"></i> Analyses de base</li>
                        <li><i class="fas fa-check"></i> Support email</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-rocket"></i>
                        Commencer l'essai
                    </a>
                </div>
                
                <div class="pricing-card popular">
                    <div class="popular-badge">Le plus populaire</div>
                    <div class="pricing-header">
                        <h3>Professional</h3>
                        <div class="price">
                            <span class="currency">€</span>
                            <span class="amount">59</span>
                            <span class="period">/mois</span>
                        </div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Jusqu'à 200 employés</li>
                        <li><i class="fas fa-check"></i> Campagnes avancées</li>
                        <li><i class="fas fa-check"></i> Analyses détaillées</li>
                        <li><i class="fas fa-check"></i> Support prioritaire</li>
                        <li><i class="fas fa-check"></i> Exports PDF/Excel</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-rocket"></i>
                        Commencer l'essai
                    </a>
                </div>
                
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Enterprise</h3>
                        <div class="price">
                            <span class="currency">€</span>
                            <span class="amount">99</span>
                            <span class="period">/mois</span>
                        </div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Employés illimités</li>
                        <li><i class="fas fa-check"></i> Fonctionnalités avancées</li>
                        <li><i class="fas fa-check"></i> API Access</li>
                        <li><i class="fas fa-check"></i> Support dédié</li>
                        <li><i class="fas fa-check"></i> Formation personnalisée</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-rocket"></i>
                        Commencer l'essai
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="about-container">
            <div class="about-content">
                <div class="about-text">
                    <h2>À Propos de RiskManager</h2>
                    <p>
                        Depuis plus de 10 ans, nous développons des solutions innovantes pour aider 
                        les entreprises à gérer efficacement leurs risques professionnels.
                    </p>
                    <p>
                        Notre équipe d'experts en sécurité au travail et en technologie a conçu 
                        RiskManager pour simplifier la prévention des risques tout en garantissant 
                        la conformité réglementaire.
                    </p>
                    
                    <div class="about-stats">
                        <div class="about-stat">
                            <h3>10+</h3>
                            <p>Années d'expérience</p>
                        </div>
                        <div class="about-stat">
                            <h3>500+</h3>
                            <p>Entreprises clientes</p>
                        </div>
                        <div class="about-stat">
                            <h3>50K+</h3>
                            <p>Employés protégés</p>
                        </div>
                    </div>
                </div>
                
                <div class="about-image">
                    <div class="about-card">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Notre Mission</h3>
                        <p>
                            Protéger la santé et la sécurité des travailleurs grâce à des 
                            outils numériques innovants et intuitifs.
                        </p>
                    </div>
                    <div class="about-card">
                        <i class="fas fa-eye"></i>
                        <h3>Notre Vision</h3>
                        <p>
                            Devenir la référence mondiale en matière de gestion digitale 
                            des risques professionnels.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="contact-container">
            <div class="section-header">
                <h2>Contactez-Nous</h2>
                <p>
                    Notre équipe est là pour vous accompagner. N'hésitez pas à nous contacter 
                    pour toute question ou démonstration personnalisée.
                </p>
            </div>
            
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>Email</h3>
                        <p>contact@riskmanager.fr</p>
                        <p>support@riskmanager.fr</p>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3>Téléphone</h3>
                        <p>+33 1 23 45 67 89</p>
                        <p>Lun-Ven, 9h-18h</p>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>Adresse</h3>
                        <p>123 Avenue de la Sécurité</p>
                        <p>75001 Paris, France</p>
                    </div>
                </div>
                
                <div class="contact-form">
                    <form>
                        <div class="form-group">
                            <label for="name">Nom complet</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="company">Entreprise</label>
                            <input type="text" id="company" name="company" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Envoyer le message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-container">
            <h2>Prêt à Sécuriser Votre Entreprise ?</h2>
            <p>
                Rejoignez des centaines d'entreprises qui font confiance à RiskManager 
                pour protéger leurs employés et optimiser leur sécurité.
            </p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="fas fa-rocket"></i>
                    Commencer Maintenant
                </a>
            @else
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-tachometer-alt"></i>
                    Accéder au Dashboard
                </a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>RiskManager</h3>
                    <p style="color: #94a3b8; margin-top: 1rem;">
                        La solution complète pour la gestion des risques professionnels.
                    </p>
                </div>
                
                <div class="footer-section">
                    <h3>Produit</h3>
                    <ul>
                        <li><a href="#features">Fonctionnalités</a></li>
                        <li><a href="{{ route('pricing') }}">Tarifs</a></li>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">API</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Entreprise</h3>
                    <ul>
                        <li><a href="#">À propos</a></li>
                        <li><a href="#">Carrières</a></li>
                        <li><a href="#">Presse</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="#">Centre d'aide</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Statut</a></li>
                        <li><a href="#">Communauté</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} RiskManager. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>

                               