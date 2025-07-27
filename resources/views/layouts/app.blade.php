<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta carset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DUERP Dashboard</title>
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
            color: white;
            overflow: hidden; /* empêche le scroll global */

        }

        /* Remove background from .dashboard-container! */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            min-width: 100%;
            
            height: 100vh; /* toute la hauteur de l'écran */
            overflow: hidden;
            /* REMOVE: background: ... */
            /* REMOVE: width: 100%; */
            /* REMOVE: background: ... */
            /* Center the container horizontally */
            justify-content: flex-start;
        }

.content-wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
    height: 100vh;
}
        /* Center the dashboard-container and limit its width */
        @media (min-width: 1280px) {
            .dashboard-container {
                max-width: 1480px; /* 280px sidebar + 1200px content */
             
            }
               .content-wrapper {
               flex: 1;
    display: flex;
    flex-direction: column;
    height: 100vh;
    }
        }

        /* Sidebar Styles */
        .sidebar {
            position: relative;
            left: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1000;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .overlay.active {
            display: block;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .brand-text h2 {
            font-family: 'Orbitron', monospace;
            font-size: 20px;
            font-weight: 700;
            color: white;
            margin-bottom: 2px;
        }

        .brand-text p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        /* User Info */
        .user-info {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .user-name {
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .user-role {
            color: #8b44ff;
            font-size: 14px;
        }

        /* Navigation */
        .sidebar-nav {
            padding: 20px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            margin-bottom: 8px;
            font-size: 15px;
        }

        .nav-item:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(139, 68, 255, 0.4);
        }

        /* Hamburger Menu */
        .hamburger {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
        }

        .hamburger:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        /* Main Content */
        .main-content {
         flex: 1;
    overflow-y: auto;
    padding: 20px;
    min-height: 0;

        }

        @media (max-width: 1280px) {
            .content-max {
                max-width: 100%;
                margin-left: 0;
                margin-right: 0;
            }
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-family: 'Orbitron', monospace;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, #8b44ff 0%, #3b82f6 100%);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 68, 255, 0.3);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon.purple {
            background: linear-gradient(135deg, rgba(139, 68, 255, 0.3), rgba(139, 68, 255, 0.5));
            color: #be9eff;
        }

        .stat-icon.green {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.5));
            color: #4ade80;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(59, 130, 246, 0.5));
            color: #60a5fa;
        }

        .stat-icon.red {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.5));
            color: #f87171;
        }

        .stat-change {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .stat-change.positive {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
        }

        .stat-change.negative {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
        }

        .stat-content h3 {
            font-size: 2.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
        }

        .stat-content p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 15px;
        }

        /* Charts Grid */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 25px;
            position: relative;
        }

        .chart-card h3 {
            color: white;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .chart-container {
            height: 300px;
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        /* Alerts */
        .alerts-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 25px;
            grid-column: 1 / -1;
        }

        .alerts-card h3 {
            color: white;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .alerts-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid;
            transition: all 0.3s ease;
        }

        .alert:hover {
            transform: translateY(-2px);
        }

        .alert.critical {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.4);
        }

        .alert.warning {
            background: rgba(245, 158, 11, 0.2);
            border-color: rgba(245, 158, 11, 0.4);
        }

        .alert.success {
            background: rgba(34, 197, 94, 0.2);
            border-color: rgba(34, 197, 94, 0.4);
        }

        .alert-icon {
            flex-shrink: 0;
            width: 20px;
            height: 20px;
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: white;
        }

        .alert-description {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.5;
        }

        /* Tablet styles */
        @media (min-width: 768px) {
            .main-content {
                padding: 30px;
            }
            
            .content-max {
                padding-top: 20px;
            }
            
            .page-header h1 {
                font-size: 3rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            }
        }

        /* Desktop styles */
        @media (min-width: 1024px) {
            .sidebar {
                position: static;
                transform: translateX(0);
                width: 280px;
                flex-shrink: 0;
            }
            
            .hamburger {
                display: none;
            }
            
            .overlay {
                display: none !important;
            }
            
            .main-content {
                padding: 40px;
            }
            
            .content-max {
                padding-top: 0;
            }
            
            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }
            
            .charts-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Large desktop */
        @media (min-width: 1440px) {
            .main-content {
                padding: 50px;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #8b44ff, #3b82f6);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #7c22f7, #2563eb);
        }
    </style>
</head>
<body>
    <div class="dashboard-bg">
        <div class="dashboard-container" >
            <x-sidebar />
            <div class="content-wrapper" >
                <!-- Hamburger, overlay, etc. -->
                <main class="main-content">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>  

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.overlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.overlay');
            
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }

        // Close sidebar when clicking navigation links on mobile
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeSidebar();
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });
    </script>
</body>
</html>