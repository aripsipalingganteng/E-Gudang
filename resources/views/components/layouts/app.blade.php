<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Gudang - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #10B981;
            --primary-dark: #059669;
            --primary-light: #D1FAE5;
            --white: #FFFFFF;
            --light-gray: #F9FAFB;
            --gray: #6B7280;
            --dark: #1F2937;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #F3F4F6;
            color: var(--dark);
            overflow-x: hidden;
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: var(--white);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            z-index: 1000;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            left: -260px;
        }
        
        .sidebar.mobile-open {
            left: 0;
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        
        .sidebar-overlay.active {
            display: block;
        }
        
        .sidebar-header {
            padding: 20px 16px;
            border-bottom: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            background: var(--white);
            z-index: 10;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo-icon {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 18px;
        }
        
        .logo-text {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
        }
        
        .sidebar-menu {
            padding: 12px 0;
        }
        
        .menu-item {
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--gray);
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            font-size: 14px;
        }
        
        .menu-item:hover, .menu-item.active {
            background: var(--primary-light);
            color: var(--primary-dark);
            border-left-color: var(--primary);
        }
        
        .menu-item i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        
        .topbar {
            background: var(--white);
            padding: 12px 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 99;
            gap: 12px;
        }
        
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }
        
        .mobile-menu-btn {
            display: flex;
            background: none;
            border: none;
            font-size: 18px;
            color: var(--gray);
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
        }
        
        .mobile-menu-btn:hover {
            background: var(--light-gray);
        }
        
        .search-bar {
            display: flex;
            align-items: center;
            background: var(--light-gray);
            border-radius: 8px;
            padding: 8px 12px;
            flex: 1;
            max-width: 400px;
        }
        
        .search-bar input {
            border: none;
            background: transparent;
            padding: 6px 8px;
            width: 100%;
            outline: none;
            font-size: 14px;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 600;
            font-size: 14px;
        }
        
        .user-info {
            display: none;
        }
        
        .content {
            padding: 16px;
            flex: 1;
        }
        
        .page-header {
            margin-bottom: 20px;
        }
        
        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 6px;
        }
        
        .page-subtitle {
            color: var(--gray);
            font-size: 13px;
            line-height: 1.4;
        }
        
        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: var(--white);
            border-radius: 10px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 16px;
            flex-shrink: 0;
        }
        
        .stat-info h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            line-height: 1.2;
        }
        
        .stat-info p {
            font-size: 12px;
            color: var(--gray);
            line-height: 1.3;
        }
        
        /* Tables */
        .card {
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .card-header {
            padding: 16px;
            border-bottom: 1px solid #E5E7EB;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark);
        }
        
        .card-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            flex: 1;
            justify-content: center;
        }
        
        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid #D1D5DB;
            color: var(--gray);
        }
        
        .btn-outline:hover {
            background: #F9FAFB;
        }
        
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 500px;
        }
        
        thead {
            background: #F9FAFB;
        }
        
        th {
            padding: 10px 12px;
            text-align: left;
            font-weight: 500;
            color: var(--gray);
            font-size: 12px;
            white-space: nowrap;
        }
        
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #E5E7EB;
            font-size: 12px;
        }
        
        .status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
            white-space: nowrap;
        }
        
        .status-in {
            background: #D1FAE5;
            color: #065F46;
        }
        
        .status-out {
            background: #FEE2E2;
            color: #991B1B;
        }
        
        .status-low {
            background: #FEF3C7;
            color: #92400E;
        }
        
        .action-buttons {
            display: flex;
            gap: 6px;
            justify-content: center;
        }
        
        .action-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F3F4F6;
            color: var(--gray);
            cursor: pointer;
            transition: all 0.2s;
            font-size: 12px;
        }
        
        .action-btn:hover {
            background: #E5E7EB;
        }
        
        .action-btn.edit:hover {
            color: var(--primary);
        }
        
        .action-btn.delete:hover {
            color: #EF4444;
        }
        
        /* Mobile First Approach */
        /* Tablet */
        @media (min-width: 768px) {
            .sidebar {
                position: static;
                left: 0;
                height: auto;
            }
            
            .sidebar-overlay {
                display: none !important;
            }
            
            .mobile-menu-btn {
                display: none;
            }
            
            .main-content {
                width: calc(100% - 260px);
            }
            
            .topbar {
                padding: 16px 20px;
            }
            
            .content {
                padding: 20px;
            }
            
            .page-title {
                font-size: 22px;
            }
            
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
            
            .stat-card {
                padding: 18px;
            }
            
            .card-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
            
            .card-actions {
                flex: 0 0 auto;
            }
            
            .btn {
                flex: 0 0 auto;
                padding: 8px 16px;
            }
            
            .user-info {
                display: block;
            }
        }
        
        /* Desktop */
        @media (min-width: 1024px) {
            .stats-container {
                grid-template-columns: repeat(4, 1fr);
            }
            
            .search-bar {
                max-width: 320px;
            }
            
            .card-header {
                padding: 20px;
            }
            
            th, td {
                padding: 12px 16px;
                font-size: 14px;
            }
            
            .status {
                font-size: 12px;
            }
        }
        
        /* Large Desktop */
        @media (min-width: 1280px) {
            .content {
                padding: 24px;
            }
            
            .stats-container {
                gap: 20px;
            }
            
            .stat-card {
                padding: 20px;
            }
        }
        
        /* Very small phones */
        @media (max-width: 360px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .stat-card {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            
            .topbar {
                flex-wrap: wrap;
            }
            
            .user-profile {
                width: 100%;
                justify-content: flex-end;
                margin-top: 8px;
            }
        }

        /* Perbaikan responsivitas untuk mobile */
        @media (max-width: 480px) {
            .card-header {
                padding: 12px;
            }
            
            .card-title {
                font-size: 14px;
            }
            
            .btn {
                padding: 6px 10px;
                font-size: 12px;
            }
            
            .action-btn {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }
            
            .page-title {
                font-size: 18px;
            }
            
            .page-subtitle {
                font-size: 12px;
            }
            
            .stat-info h3 {
                font-size: 16px;
            }
            
            .stat-info p {
                font-size: 11px;
            }
            
            .stat-icon {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }
            
            .search-bar {
                min-width: 0;
            }
            
            .topbar {
                padding: 10px 12px;
            }
            
            .content {
                padding: 12px;
            }
            
            table {
                min-width: 600px; /* Membuat tabel lebih lebar untuk mobile */
            }
        }

        /* Perbaikan untuk layar sangat kecil */
        @media (max-width: 320px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .card-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .btn {
                width: 100%;
            }
            
            .topbar-left {
                flex-wrap: wrap;
            }
            
            .search-bar {
                order: 2;
                width: 100%;
                margin-top: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container" x-data="{ mobileMenuOpen: false }">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" 
             :class="{ 'active': mobileMenuOpen }"
             @click="mobileMenuOpen = false"
             x-show="mobileMenuOpen"
             x-transition></div>
        
        <!-- Sidebar -->
        <div class="sidebar" :class="{ 'mobile-open': mobileMenuOpen }">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="logo-text">E-Gudang</div>
                </div>
            </div>
            
            @include('components.layouts.sidebar')
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
            @include('components.layouts.header')
            
            <!-- Content -->
            {{$slot}}
        </div>
    </div>

    <script>
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnMenuBtn = mobileMenuBtn.contains(event.target);
            
            if (!isClickInsideSidebar && !isClickOnMenuBtn && window.innerWidth < 768) {
                Alpine.store('mobileMenuOpen', false);
            }
        });
    </script>
</body>
</html>