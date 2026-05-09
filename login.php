<?php
session_start();

if (isset($_SESSION['admin'])) {
    header('Location: admin.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'db.php';
    
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));
    
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $admin = $stmt->fetch();
    
    if ($admin) {
        $_SESSION['admin'] = $admin['username'];
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Invalid username or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background: var(--card);
            padding: 40px;
            border-radius: 16px;
            border: 1px solid var(--primary);
            width: 100%;
            max-width: 400px;
        }
        .login-box h2 {
            color: var(--primary);
            margin-bottom: 30px;
            text-align: center;
        }
        .login-box input {
            width: 100%;
            background: var(--bg);
            border: 1px solid var(--primary);
            color: var(--text);
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 15px;
            outline: none;
        }
        .login-box button {
            width: 100%;
            background: var(--primary);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
        }
        .error {
            color: #ff4444;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>🔐 Admin Login</h2>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>