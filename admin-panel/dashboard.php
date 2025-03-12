<?php
session_start();
require 'database.php'; // Database connection

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch admin details
try {
    $stmt = $pdo->prepare("SELECT name FROM admins WHERE id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    $admin = $stmt->fetch();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { display: flex; height: 100vh; }
        .sidebar { width: 250px; background: #007BFF; padding: 20px; color: white; }
        .sidebar h2 { font-size: 20px; text-align: center; margin-bottom: 20px; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 10px; margin: 5px 0; border-radius: 5px; }
        .sidebar a:hover { background: rgba(255, 255, 255, 0.2); }
        .content { flex-grow: 1; padding: 20px; }
        header { background: #f8f9fa; padding: 10px; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="index.php">🏠 Home</a>
        <a href="manage_appointments.php">📅 Manage Appointments</a>
        <a href="manage_doctors.php">👨‍⚕️ Manage Doctors</a>
        <a href="messages.php">📩 View Messages</a>
        <a href="profile.php">👤 Admin Profile</a>
        <a href="logout.php">🚪 Log Out</a>
    </div>
    <div class="content">
        <header>
            <h2>Welcome, <?php echo htmlspecialchars($admin['name']); ?>!</h2>
        </header>
        <p>This is your dashboard. Select an option from the sidebar.</p>
    </div>
</body>
</html>
