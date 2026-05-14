<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require_once 'db.php';

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: admin.php');
    exit;
}

// إضافة مشروع
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $tech = trim($_POST['tech']);
    $link = trim($_POST['link']);
    
    $stmt = $pdo->prepare("INSERT INTO projects (title, description, tech, link) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $description, $tech, $link]);
    header('Location: admin.php');
    exit;
}

$projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll();

$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .dashboard { padding: 40px; max-width: 1000px; margin: 0 auto; }
        .dashboard h1 { color: var(--primary); margin-bottom: 30px; }
        .add-form { background: var(--card); padding: 30px; border-radius: 16px; margin-bottom: 40px; border: 1px solid var(--primary); }
        .add-form h2 { color: var(--primary); margin-bottom: 20px; }
        .add-form input { width: 100%; background: var(--bg); border: 1px solid var(--primary); color: var(--text); padding: 10px 14px; border-radius: 8px; font-size: 0.95rem; margin-bottom: 12px; outline: none; }
        .add-form button { background: var(--primary); color: white; padding: 10px 24px; border: none; border-radius: 8px; cursor: pointer; font-size: 1rem; }
        .projects-list { margin-bottom: 40px; }
        .project-item { background: var(--card); padding: 20px; border-radius: 12px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; border: 1px solid rgba(108,99,255,0.2); }
        .project-item h3 { color: var(--primary); }
        .project-item p { color: var(--text2); font-size: 0.9rem; }
        .delete-btn { background: #ff4444; color: white; padding: 8px 16px; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; font-size: 0.85rem; }
        .messages-list .msg { background: var(--card); padding: 20px; border-radius: 12px; margin-bottom: 15px; border: 1px solid rgba(108,99,255,0.2); }
        .msg h4 { color: var(--primary); }
        .msg p { color: var(--text2); font-size: 0.9rem; }
        .logout { float: right; background: #ff4444; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; }
    </style>
</head>
<body>
<div class="dashboard">
    <a href="logout.php" class="logout">Logout</a>
    <h1>🛠️ Admin Dashboard</h1>

    <!-- Add Project Form -->
    <div class="add-form">
        <h2>Add New Project</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Project Title" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="text" name="tech" placeholder="Technologies (e.g. HTML, CSS, JS)" required>
            <input type="text" name="link" placeholder="Project Link" required>
            <button type="submit">Add Project</button>
        </form>
    </div>

    <!-- Projects List -->
    <div class="projects-list">
        <h2 style="color:var(--primary);margin-bottom:20px;">Projects</h2>
        <?php foreach ($projects as $project): ?>
        <div class="project-item">
            <div>
                <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                <p><?php echo htmlspecialchars($project['tech']); ?></p>
            </div>
            <a href="admin.php?delete=<?php echo $project['id']; ?>" class="delete-btn" onclick="return confirm('Delete this project?')">Delete</a>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Messages -->
    <div class="messages-list">
        <h2 style="color:var(--primary);margin-bottom:20px;">Messages</h2>
        <?php foreach ($messages as $msg): ?>
        <div class="msg">
            <h4><?php echo htmlspecialchars($msg['name']); ?> - <?php echo htmlspecialchars($msg['email']); ?></h4>
            <p><?php echo htmlspecialchars($msg['message']); ?></p>
            <small style="color:var(--text2)"><?php echo $msg['created_at']; ?></small>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>