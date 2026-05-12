<?php
if (file_exists('includes/db.php')) {
    include 'includes/db.php';
} else {
    include 'db.php';
}

if (isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = $admin['id'];
        header("Location: index.php");
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | GramBazar Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --bg: #f8fafc;
        }
        body { font-family: 'Outfit', sans-serif; background: var(--bg); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card {
            background: #fff;
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        .logo {
            background: var(--primary);
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: #fff;
            font-size: 1.5rem;
        }
        h1 { font-size: 1.75rem; margin-bottom: 0.5rem; color: #1e293b; }
        p { color: #64748b; margin-bottom: 2rem; }
        .form-group { text-align: left; margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 0.9rem; color: #1e293b; }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            outline: none;
            font-size: 1rem;
            transition: all 0.2s;
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }
        .btn {
            width: 100%;
            background: var(--primary);
            color: #fff;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn:hover { background: #4f46e5; transform: translateY(-1px); }
        .error { color: #ef4444; font-size: 0.85rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo"><i class="fas fa-shopping-bag"></i></div>
        <h1>Welcome Back</h1>
        <p>Enter your credentials to access the admin panel</p>
        
        <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
        
        <form action="" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="admin" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn">Login to Dashboard</button>
        </form>
        
        <div style="margin-top: 2rem; font-size: 0.85rem; color: #94a3b8;">
            GramBazar &copy; 2024. All rights reserved.
        </div>
    </div>
</body>
</html>
