<?php
session_start();
require 'database.php'; // Database connection

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle Create & Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $patient_name = trim($_POST['patient_name']);
    $doctor_id = trim($_POST['doctor_id']);
    $appointment_date = trim($_POST['appointment_date']);
    $message = trim($_POST['message']);

    if (!empty($patient_name) && !empty($doctor_id) && !empty($appointment_date) && !empty($message)) {
        try {
            if ($id) {
                // Update existing appointment
                $stmt = $pdo->prepare("UPDATE appointments SET patient_name = ?, doctor_id = ?, appointment_date = ?, message = ? WHERE id = ?");
                $stmt->execute([$patient_name, $doctor_id, $appointment_date, $message, $id]);
            } else {
                // Create new appointment
                $stmt = $pdo->prepare("INSERT INTO appointments (patient_name, doctor_id, appointment_date, message) VALUES (?, ?, ?, ?)");
                $stmt->execute([$patient_name, $doctor_id, $appointment_date, $message]);
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: manage_appointments.php");
        exit();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

// Fetch appointments & doctors
try {
    $stmt = $pdo->query("SELECT appointments.id, patient_name, doctors.name AS doctor_name, appointments.appointment_date, appointments.message 
                         FROM appointments 
                         JOIN doctors ON appointments.doctor_id = doctors.id 
                         ORDER BY appointments.appointment_date DESC");
    $appointments = $stmt->fetchAll();

    $stmt = $pdo->query("SELECT id, name FROM doctors");
    $doctors = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { display: flex; height: 100vh; background: #f8f9fa; }
        .sidebar { width: 250px; background: #007BFF; padding: 20px; color: white; }
        .sidebar h2 { font-size: 20px; text-align: center; margin-bottom: 20px; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 10px; margin: 5px 0; border-radius: 5px; }
        .sidebar a:hover { background: rgba(255, 255, 255, 0.2); }
        .content { flex-grow: 1; padding: 20px; }
        header { background: white; padding: 10px; border-bottom: 1px solid #ddd; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #007BFF; color: white; }
        tr:nth-child(even) { background: #f2f2f2; }
        .btn { padding: 5px 10px; border: none; cursor: pointer; border-radius: 5px; text-decoration: none; }
        .edit { background: #28a745; color: white; }
        .delete { background: #dc3545; color: white; }
        .form-container { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin-top: 20px; }
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
        <header>
            <h2><i class="fas fa-calendar-alt"></i>Manage Appointments</h2>
        </header>

        <div class="form-container">
            <h3><?php echo isset($_GET['edit']) ? 'Edit' : 'Add'; ?> Appointment</h3>
            <form action="manage_appointments.php" method="post">
                <input type="hidden" name="id" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">
                <label>Patient Name:</label>
                <input type="text" name="patient_name" required>
                <label>Doctor:</label>
                <select name="doctor_id" required>
                    <option value="">Select a Doctor</option>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?= $doctor['id']; ?>"><?= htmlspecialchars($doctor['name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Appointment Date:</label>
                <input type="date" name="appointment_date" required>
                <label>Message:</label>
                <textarea name="message" rows="3" required></textarea>
                <button type="submit" class="btn edit">Save Appointment</button>
            </form>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td><?php echo htmlspecialchars($appointment['id']); ?></td>
                <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                <td><?php echo htmlspecialchars($appointment['message']); ?></td>
                <td>
                    <a href="manage_appointments.php?edit=<?= $appointment['id']; ?>" class="btn edit">Edit</a>
                    <a href="manage_appointments.php?delete=<?= $appointment['id']; ?>" class="btn delete" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>


