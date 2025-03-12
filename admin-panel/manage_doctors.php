<?php
session_start();
require 'database.php'; // Database connection

// Ensure the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle Add Doctor
if (isset($_POST['add_doctor'])) {
    try {
        $stmt = $pdo->prepare("INSERT INTO doctors (name, specialty, email, phone) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['specialty'], $_POST['email'], $_POST['phone']]);
        $success = "Doctor added successfully!";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle Update Doctor
if (isset($_POST['update_doctor'])) {
    try {
        $stmt = $pdo->prepare("UPDATE doctors SET name = ?, specialty = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->execute([$_POST['name'], $_POST['specialty'], $_POST['email'], $_POST['phone'], $_POST['doctor_id']]);
        $success = "Doctor updated successfully!";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle Delete Doctor
if (isset($_GET['delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM doctors WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        $success = "Doctor deleted successfully!";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Fetch all doctors
$doctors = $pdo->query("SELECT * FROM doctors ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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
        form { margin-bottom: 20px; }
        input, button { padding: 8px; margin: 5px; width: 100%; }
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
        <a href="messages.php">📩 View Messages</a>
        <a href="profile.php">👤 Admin Profile</a>
        <a href="logout.php">🚪 Log Out</a>
    </div>
    
    <div class="content">
        <h2>Manage Doctors</h2>

        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <!-- Add Doctor Form -->
        <form method="post">
            <h3>Add Doctor</h3>
            <input type="text" name="name" placeholder="Doctor Name" required>
            <input type="text" name="specialty" placeholder="Specialty" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <button type="submit" name="add_doctor">Add Doctor</button>
        </form>

        <!-- Doctors Table -->
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Specialty</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($doctors as $doctor): ?>
            <tr>
                <td><?php echo $doctor['id']; ?></td>
                <td><?php echo htmlspecialchars($doctor['name']); ?></td>
                <td><?php echo htmlspecialchars($doctor['specialty']); ?></td>
                <td><?php echo htmlspecialchars($doctor['email']); ?></td>
                <td><?php echo htmlspecialchars($doctor['phone']); ?></td>
                <td>
                    <button onclick="editDoctor(<?php echo $doctor['id']; ?>, '<?php echo htmlspecialchars($doctor['name']); ?>', '<?php echo htmlspecialchars($doctor['specialty']); ?>', '<?php echo htmlspecialchars($doctor['email']); ?>', '<?php echo htmlspecialchars($doctor['phone']); ?>')">✏️ Edit</button>
                    <a href="manage_doctors.php?delete=<?php echo $doctor['id']; ?>" onclick="return confirm('Are you sure?')">❌ Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- Edit Doctor Form (Hidden) -->
        <form method="post" id="editForm" style="display: none;">
            <h3>Edit Doctor</h3>
            <input type="hidden" name="doctor_id" id="doctor_id">
            <input type="text" name="name" id="edit_name" required>
            <input type="text" name="specialty" id="edit_specialty" required>
            <input type="email" name="email" id="edit_email" required>
            <input type="text" name="phone" id="edit_phone" required>
            <button type="submit" name="update_doctor">Update Doctor</button>
        </form>
    </div>

    <script>
        function editDoctor(id, name, specialty, email, phone) {
            document.getElementById("editForm").style.display = "block";
            document.getElementById("doctor_id").value = id;
            document.getElementById("edit_name").value = name;
            document.getElementById("edit_specialty").value = specialty;
            document.getElementById("edit_email").value = email;
            document.getElementById("edit_phone").value = phone;
            window.scrollTo(0, document.getElementById("editForm").offsetTop);
        }
    </script>
</body>
</html>
