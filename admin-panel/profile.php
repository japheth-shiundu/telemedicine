<?php
session_start();
require 'database.php'; // Database connection

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch admin details
try {
    $stmt = $pdo->prepare("SELECT name, email, qualifications, profile_pic FROM admins WHERE id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    $admin = $stmt->fetch();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $uploadDir = "uploads/";
    $fileName = basename($_FILES["profile_pic"]["name"]);
    $targetFilePath = $uploadDir . $fileName;

    // Allow only image file types
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = ["jpg", "jpeg", "png", "gif"];

    if (in_array($imageFileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFilePath)) {
            $stmt = $pdo->prepare("UPDATE admins SET profile_pic = ? WHERE id = ?");
            $stmt->execute([$targetFilePath, $_SESSION['admin_id']]);
            header("Location: profile.php"); // Refresh page
            exit();
        } else {
            $error = "Error uploading file.";
        }
    } else {
        $error = "Only JPG, JPEG, PNG & GIF files are allowed.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { display: flex; height: 100vh; }
        .sidebar { width: 250px; background: #007BFF; padding: 20px; color: white; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 10px; margin: 5px 0; border-radius: 5px; }
        .sidebar a:hover { background: rgba(255, 255, 255, 0.2); }
        .content { flex-grow: 1; padding: 20px; display: flex; align-items: center; }
        .profile-left { flex: 1; text-align: center; }
        .profile-left img { width: 150px; height: 150px; border-radius: 50%; border: 3px solid #007BFF; }
        .profile-right { flex: 2; padding-left: 20px; }
        h2 { margin-bottom: 10px; }
        form { margin-top: 10px; }
        input[type="file"], button { margin-top: 5px; padding: 8px; width: 100%; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="index.php">🏠 Home</a>
        <a href="manage_appointments.php">📅 Manage Appointments</a>
        <a href="manage_doctors.php">👨‍⚕️ Manage Doctors</a>
        <a href="profile.php">👤 Admin Profile</a>
        <a href="logout.php">🚪 Log Out</a>
    </div>

    <div class="content">
        <div class="profile-left">
            <h2>Profile Picture</h2>
            <img src="<?php echo $admin['profile_pic'] ?: 'default-profile.png'; ?>" alt="Profile Picture">
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="profile_pic" required>
                <button type="submit">Upload</button>
            </form>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        </div>
        
        <div class="profile-right">
            <h2>Admin Profile</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($admin['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($admin['email']); ?></p>
            <p><strong>Qualifications:</strong> <?php echo htmlspecialchars($admin['qualifications']); ?></p>
        </div>
    </div>
</body>
</html>
