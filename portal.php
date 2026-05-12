<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GramBazar Ecosystem | Digital Commerce Platform</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --secondary: #1e293b;
            --accent: #f59e0b;
            --bg: #0f172a;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --glass: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: var(--bg);
            color: var(--text-main);
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(245, 158, 11, 0.1) 0%, transparent 40%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Navbar */
        nav {
            padding: 2rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: fadeInDown 0.8s ease-out;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo i {
            background: var(--primary);
            padding: 10px;
            border-radius: 12px;
            font-size: 1.2rem;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }

        .logo span {
            background: linear-gradient(to right, #fff, var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Hero Section */
        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            padding: 4rem 0;
        }

        .hero-content h1 {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            animation: fadeInLeft 1s ease-out;
        }

        .hero-content h1 span {
            color: var(--primary);
        }

        .hero-content p {
            font-size: 1.2rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            line-height: 1.6;
            animation: fadeInLeft 1.2s ease-out;
        }

        .cta-group {
            display: flex;
            gap: 1rem;
            animation: fadeInLeft 1.4s ease-out;
        }

        .btn {
            padding: 1rem 2rem;
            border-radius: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(99, 102, 241, 0.5);
        }

        .btn-outline {
            border: 2px solid var(--glass-border);
            color: #fff;
            background: var(--glass);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #fff;
        }

        .hero-image {
            position: relative;
            animation: fadeInRight 1.5s ease-out;
        }

        .hero-image img {
            width: 100%;
            border-radius: 30px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.5);
            border: 1px solid var(--glass-border);
        }

        /* Floating Cards Section */
        .ecosystem-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 4rem;
            padding-bottom: 6rem;
        }

        .ecosystem-card {
            background: var(--glass);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            padding: 2.5rem;
            border-radius: 24px;
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 1s ease-out backwards;
        }

        .ecosystem-card:nth-child(2) { animation-delay: 0.2s; }
        .ecosystem-card:nth-child(3) { animation-delay: 0.4s; }

        .ecosystem-card:hover {
            transform: translateY(-15px);
            border-color: var(--primary);
            background: rgba(30, 41, 59, 0.9);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            background: rgba(99, 102, 241, 0.1);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .ecosystem-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .ecosystem-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .card-link {
            color: var(--primary-light);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .card-link i {
            transition: transform 0.3s;
        }

        .card-link:hover i {
            transform: translateX(5px);
        }

        /* Animations */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Responsive */
        @media (max-width: 968px) {
            .hero { grid-template-columns: 1fr; text-align: center; }
            .hero-content h1 { font-size: 3rem; }
            .cta-group { justify-content: center; }
            .ecosystem-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <nav>
            <div class="logo">
                <i class="fas fa-shopping-bag"></i>
                <span>GramBazar</span>
            </div>
            <a href="login.php" class="btn btn-outline btn-sm">
                <i class="fas fa-user-shield"></i> Admin Login
            </a>
        </nav>

        <section class="hero">
            <div class="hero-content">
                <h1>The Future of <span>Hyper-Local</span> Commerce</h1>
                <p>A unified ecosystem connecting vendors, customers, and delivery partners through state-of-the-art technology. Manage everything from a single, powerful dashboard.</p>
                <div class="cta-group">
                    <a href="login.php" class="btn btn-primary">
                        Go to Dashboard <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="#apps" class="btn btn-outline">
                        Get the Apps <i class="fas fa-mobile-alt"></i>
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <img src="ecosystem_mockup.png" alt="GramBazar Ecosystem">
            </div>
        </section>

        <div id="apps" class="ecosystem-grid">
            <!-- Admin Panel Card -->
            <div class="ecosystem-card">
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Central Admin Panel</h3>
                <p>Master control center for managing orders, products, vendors, and delivery boys. Real-time statistics and detailed sales reports at your fingertips.</p>
                <a href="login.php" class="card-link">Launch Console <i class="fas fa-external-link-alt"></i></a>
            </div>

            <!-- Customer App Card -->
            <div class="ecosystem-card">
                <div class="card-icon" style="color: var(--accent); background: rgba(245, 158, 11, 0.1);">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3>GramBazar Store</h3>
                <p>The ultimate shopping experience for customers. Browse thousands of products, place orders, and track deliveries in real-time with our mobile application.</p>
                <a href="#" class="card-link" style="color: var(--accent);">Coming to Android <i class="fab fa-android"></i></a>
            </div>

            <!-- Delivery App Card -->
            <div class="ecosystem-card">
                <div class="card-icon" style="color: #10b981; background: rgba(16, 185, 129, 0.1);">
                    <i class="fas fa-motorcycle"></i>
                </div>
                <h3>Delivery Partner</h3>
                <p>Empowering our delivery fleet with real-time assignment tracking, GPS navigation, and secure verification systems to ensure every package arrives safely.</p>
                <a href="#" class="card-link" style="color: #10b981;">Download Partner App <i class="fas fa-download"></i></a>
            </div>
        </div>
    </div>

    <footer style="padding: 4rem 0; text-align: center; border-top: 1px solid var(--glass-border);">
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            &copy; 2024 GramBazar Ecosystem. All rights reserved. <br>
            Powered by Premium Web Technology.
        </p>
    </footer>
</body>
</html>
