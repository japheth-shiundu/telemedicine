<?php
require 'admin-panel/database.php'; // Database connection

try {
    // Fetch all doctors from the database
    $stmt = $pdo->query("SELECT name, specialty FROM doctors");
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a Doctor</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Poppins', sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; text-align: center;">

    <header style="background: #007BFF; color: white; padding: 15px 0;">
        <h1>Find a Doctor</h1>
        <nav>
            <a href="index.php" style="margin: 0 15px; color: white; text-decoration: none;">Home</a>
            <a href="doctors.php" style="margin: 0 15px; color: white; text-decoration: none;">Find a Doctor</a>
            <a href="appointment.php" style="margin: 0 15px; color: white; text-decoration: none;">Book Appointment</a>
            <a href="contact.php" style="margin: 0 15px; color: white; text-decoration: none;">Contact</a>
        </nav>
    </header>

    <section style="padding: 20px;">
        <h2>Available Doctors</h2>
        <p>Search for a doctor and book a consultation.</p>

        <table style="width: 100%; max-width: 600px; margin: 20px auto; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #007BFF; color: white;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Doctor Name</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Specialty</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($doctors)): ?>
                    <?php foreach ($doctors as $doctor): ?>
                        <tr style="background: #fff;">
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($doctor['name']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($doctor['specialty']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" style="padding: 10px; border: 1px solid #ddd; text-align: center;">No doctors available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <footer style="background: #333; color: white; padding: 10px;">
        <p>&copy; 2025 Telemedicine Exchange. All Rights Reserved.</p>
    </footer>

</body>
</html>

