<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GramBazar | Premium Admin Panel</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --sidebar-width: 260px;
            --header-height: 70px;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* Layout Structure */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: #1e293b;
            color: #fff;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .sidebar-header span {
            color: var(--primary);
        }

        .sidebar-menu {
            padding: 0.5rem;
        }

        .menu-label {
            padding: 1rem 1rem 0.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            font-weight: 600;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 5px;
            transition: all 0.2s;
        }

        .menu-item i {
            width: 24px;
            margin-right: 12px;
            font-size: 1.1rem;
            text-align: center;
        }

        .menu-item:hover, .menu-item.active {
            background: rgba(99, 102, 241, 0.1);
            color: #fff;
        }

        .menu-item.active {
            background: var(--primary);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
            transition: all 0.3s;
        }

        header {
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .search-bar {
            background: #fff;
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            width: 350px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
        }

        .search-bar input {
            border: none;
            outline: none;
            width: 100%;
            margin-left: 10px;
            font-size: 0.9rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notifications {
            width: 40px;
            height: 40px;
            background: #fff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
        }

        .notifications .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger);
            color: #fff;
            font-size: 10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--primary);
        }

        /* Card Styles */
        .card {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            margin-bottom: 1.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-info h3 {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 5px;
        }

        .stat-info p {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.primary { background: rgba(99, 102, 241, 0.1); color: var(--primary); }
        .stat-icon.success { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .stat-icon.warning { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
        .stat-icon.info { background: rgba(59, 130, 246, 0.1); color: var(--info); }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 1.2rem 1rem;
            font-size: 0.9rem;
            border-bottom: 1px solid var(--border);
        }

        tr:last-child td {
            border-bottom: none;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-info { background: rgba(59, 130, 246, 0.1); color: var(--info); }
        .badge-warning { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
        .badge-success { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .badge-danger { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
        .badge-primary { background: rgba(99, 102, 241, 0.1); color: var(--primary); }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text-main); }
        .btn-outline:hover { background: var(--bg-body); }

        .btn-sm { padding: 6px 12px; font-size: 0.8rem; }

        /* Grid System */
        .grid-2 { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; }

        /* Forms */
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 0.9rem; }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid var(--border);
            outline: none;
            transition: all 0.2s;
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade { animation: fadeIn 0.4s ease-out forwards; }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div style="background: var(--primary); padding: 8px; border-radius: 10px;">
                    <i class="fas fa-shopping-bag" style="color: #fff; font-size: 1.2rem;"></i>
                </div>
                <h2>Gram<span>Bazar</span></h2>
            </div>
            
            <div class="sidebar-menu">
                <div class="menu-label">Main</div>
                <a href="index.php" class="menu-item active">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                
                <div class="menu-label">E-Commerce</div>
                <a href="orders.php" class="menu-item">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
                <a href="products.php" class="menu-item">
                    <i class="fas fa-box"></i> Products
                </a>
                <a href="categories.php" class="menu-item">
                    <i class="fas fa-tags"></i> Categories
                </a>
                
                <div class="menu-label">Personnel</div>
                <a href="vendors.php" class="menu-item">
                    <i class="fas fa-store"></i> Vendors
                </a>
                <a href="delivery_boys.php" class="menu-item">
                    <i class="fas fa-motorcycle"></i> Delivery Boys
                </a>
                <a href="customers.php" class="menu-item">
                    <i class="fas fa-users"></i> Customers
                </a>

                <div class="menu-label">Reports</div>
                <a href="sales_report.php" class="menu-item">
                    <i class="fas fa-chart-line"></i> Sales Report
                </a>
                
                <div class="menu-label">Settings</div>
                <a href="settings.php" class="menu-item">
                    <i class="fas fa-cog"></i> General Settings
                </a>
                <a href="logout.php" class="menu-item" style="color: var(--danger);">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="main-content">
            <header>
                <div class="search-bar">
                    <i class="fas fa-search" style="color: var(--text-muted);"></i>
                    <input type="text" placeholder="Search orders, products, etc...">
                </div>
                
                <div class="user-profile">
                    <div class="notifications">
                        <i class="far fa-bell"></i>
                        <span class="badge">3</span>
                    </div>
                    <div class="user-info">
                        <div style="text-align: right;">
                            <p style="font-weight: 600; font-size: 0.9rem;">Admin User</p>
                            <p style="color: var(--text-muted); font-size: 0.75rem;">Super Admin</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=6366f1&color=fff" alt="Avatar" class="user-avatar">
                    </div>
                </div>
            </header>
