<!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <!-- Header -->
              
            <div class="sidebar-header">
                <div class="brand-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 21h18"/>
                        <path d="M5 21V7l8-4v18"/>
                        <path d="M19 21V11l-6-4"/>
                    </svg>
                </div>
                <div class="brand-text">
                    <h2>DUERP</h2>
                    <p>AI Assistant</p>
                </div>
            </div>

            <!-- User Info -->
            @auth
            <div class="user-info">
                <div class="user-avatar">
                    <span>{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                </div>
                <div class="user-details">
                    <p class="user-name">{{ auth()->user()->name }}</p>
                    <p class="user-role">
                   @if (auth()->user()->hasRole('admin'))
                        <span class="badge badge-admin">Administrateur</span>
                    @elseif (auth()->user()->hasRole('referent'))
                        <span class="badge badge-referent">Référent</span>
                    @elseif (auth()->user()->hasRole('employer'))
                        <span class="badge badge-employer">Employé</span>
                    @else
                        <span class="badge badge-guest">Invité</span>
                    @endif
                </p>
                </div>
            </div>

            @endauth

            <!-- Navigation -->
            <nav class="sidebar-nav">
@auth
    @if(auth()->user()->hasRole('referent'))
        <!-- Referent links -->
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <!-- ...icon... -->
            <span>Dashboard</span>
        </a>
        <a href="{{ route('structure') }}" class="nav-item {{ request()->routeIs('structure') ? 'active' : '' }}">
            <!-- ...icon... -->
            <span>Structure</span>
        </a>
        <a href="{{ route('metiers') }}" class="nav-item {{ request()->routeIs('metiers') ? 'active' : '' }}">
            <!-- ...icon... -->
            <span>Banque de questions</span>
        </a>
        <a href="{{ route('salaries') }}" class="nav-item {{ request()->routeIs('salaries') ? 'active' : '' }}">
            <!-- ...icon... -->
            <span>Salariés & Métiers</span>
        </a>
        <a href="{{ route('campagnes') }}" class="nav-item {{ request()->routeIs('campagnes') || request()->routeIs('questions.campaigns') ? 'active' : '' }}">
            <!-- ...icon... -->
            <span>Campagnes</span>
        </a>
        <a href="{{ route('resultats') }}" class="nav-item {{ request()->routeIs('resultats') || request()->routeIs('questions.campaigns.results') ? 'active' : '' }}">
            <!-- ...icon... -->
            <span>Résultats</span>
        </a>
    @endif

    @if(auth()->user()->hasRole('employer'))
        <!-- Employer links -->
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <!-- ...icon... -->
            <span>Mon Tableau de Bord</span>
        </a>
        <a href="{{ route('profile.show') }}" class="nav-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
            <span class="sidebar-icon">👤</span>
            <span>Mon Profil</span>
        </a>
        <a href="{{ route('quiz') }}" class="nav-item {{ request()->routeIs('quiz') ? 'active' : '' }}">
            <span class="sidebar-icon">📋</span>
            <span>Mes Campagnes</span>
        </a>
        <a href="{{ route('mes.resultats') }}" class="nav-item {{ request()->routeIs('mes.resultats') ? 'active' : '' }}">
            <span class="sidebar-icon">📊</span>
            <span>Mes Résultats</span>
        </a>
    @endif
@endauth
</nav>

    <!-- Logout Button at the bottom -->
    @auth
    <form method="POST" action="{{ route('logout') }}" style="position: absolute; bottom: 24px; left: 0; width: 100%; text-align: center;">
        @csrf
        <button type="submit" class="nav-item" style="background: none; border: none; color: #f87171; font-weight: 600; font-size: 15px; cursor: pointer; padding: 12px 0;">
            <span class="sidebar-icon">⏻</span>
            Déconnexion
        </button>
    </form>
    @endauth
        </div>