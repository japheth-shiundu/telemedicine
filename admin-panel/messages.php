<?php
session_start();
require 'database.php'; // Ensure database connection

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle message deletion
if (isset($_GET['delete'])) {
    $message_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$message_id]);
    header("Location: messages.php");
    exit();
}

// Fetch all messages
try {
    $stmt = $pdo->query("SELECT id, name, email, message FROM messages ORDER BY created_at DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Messages</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { display: flex; height: 100vh; }
        .sidebar { width: 250px; background: #007BFF; padding: 20px; color: white; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 10px; margin: 5px 0; border-radius: 5px; }
        .sidebar a:hover { background: rgba(255, 255, 255, 0.2); }
        .content { flex-grow: 1; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #007BFF; color: white; }
        .delete-btn { color: red; text-decoration: none; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="index.php"><i class="fas fa-home"></i> Home</a> 
        <a href="manage_appointments.php"><i class="fas fa-calendar-alt"></i> Manage Appointments</a>
        <a href="manage_doctors.php"><i class="fas fa-user-md"></i> Manage Doctors</a>
        <a href="messages.php"><i class="fas fa-envelope"></i> View Messages</a>
        <a href="profile.php"><i class="fas fa-user"></i> Admin Profile</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
    </div>
    <div class="content">
        <h2>📩 Messages</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?= htmlspecialchars($message['id']); ?></td>
                        <td><?= htmlspecialchars($message['name']); ?></td>
                        <td><?= htmlspecialchars($message['email']); ?></td>
                        <td><?= htmlspecialchars($message['message'] ?? 'No content available'); ?></td>
                        <td><a href="messages.php?delete=<?= $message['id']; ?>" class="delete-btn">❌ Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
