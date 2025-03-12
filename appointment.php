<?php
require 'admin-panel/database.php';

// Fetch available doctors from the database
$stmt = $pdo->query("SELECT id, name FROM doctors");
$doctors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Poppins', sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; text-align: center;">

    <header style="background: #007BFF; color: white; padding: 15px 0;">
        <h1>Book an Appointment</h1>
        <nav>
            <a href="index.php" style="margin: 0 15px; color: white; text-decoration: none;">Home</a>
            <a href="doctors.php" style="margin: 0 15px; color: white; text-decoration: none;">Find a Doctor</a>
            <a href="appointment.php" style="margin: 0 15px; color: white; text-decoration: none;">Book Appointment</a>
            <a href="contact.php" style="margin: 0 15px; color: white; text-decoration: none;">Contact</a>
        </nav>
    </header>

    <section style="width: 90%; max-width: 400px; margin: 20px auto; padding: 20px; background: white; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: left; box-sizing: border-box;">
    <h2 style="text-align: center;">Schedule an Appointment</h2>

    <form action="book_appointment.php" method="post" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
        <label for="name" style="margin-top: 10px; font-weight: bold; width: 100%;">Your Name:</label>
        <input type="text" id="name" name="name" required 
            style="padding: 10px; width: 90%; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">

        <label for="doctor_id" style="margin-top: 10px; font-weight: bold; width: 100%;">Choose a Doctor:</label>
        <select id="doctor_id" name="doctor_id" required 
            style="padding: 10px; width: 90%; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            <option value="">Select a Doctor</option>
            <?php foreach ($doctors as $doctor): ?>
                <option value="<?= $doctor['id']; ?>"><?= htmlspecialchars($doctor['name']); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="date" style="margin-top: 10px; font-weight: bold; width: 100%;">Select Appointment Date:</label>
        <input type="date" id="date" name="date" required 
            style="padding: 10px; width: 90%; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">

        <label for="message" style="margin-top: 10px; font-weight: bold; width: 100%;">Additional Message:</label>
        <textarea id="message" name="message" rows="4" required 
            style="padding: 10px; width: 90%; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;"></textarea>

        <button type="submit" 
            style="margin-top: 15px; background: #007BFF; color: white; padding: 12px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; width: 90%;">
            Book Now
        </button>
    </form>
</section>

    <footer style="background: #333; color: white; padding: 10px;">
        <p>&copy; 2025 Telemedicine Exchange. All Rights Reserved.</p>
    </footer>

</body>
</html>
