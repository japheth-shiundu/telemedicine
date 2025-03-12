<?php
require 'admin-panel/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name = trim($_POST['name']);
    $doctor_id = trim($_POST['doctor_id']);
    $appointment_date = trim($_POST['date']);
    $message = trim($_POST['message']);
    $status = 'pending'; // Default status

    if (!empty($patient_name) && !empty($doctor_id) && !empty($appointment_date) && !empty($message)) {
        try {
            // Fetch doctor name from doctors table
            $stmt = $pdo->prepare("SELECT name FROM doctors WHERE id = ?");
            $stmt->execute([$doctor_id]);
            $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$doctor) {
                die("Error: Selected doctor does not exist.");
            }

            $doctor_name = $doctor['name']; // Get doctor name

            // Insert appointment into database
            $stmt = $pdo->prepare("INSERT INTO appointments (doctor_name, patient_name, doctor_id, appointment_date, message, status, created_at) 
                                   VALUES (:doctor_name, :patient_name, :doctor_id, :appointment_date, :message, :status, NOW())");
            $stmt->execute([
                ':doctor_name' => $doctor_name,
                ':patient_name' => $patient_name,
                ':doctor_id' => $doctor_id,
                ':appointment_date' => $appointment_date,
                ':message' => $message,
                ':status' => $status
            ]);

            // Success message
            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Success</title>
                <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap' rel='stylesheet'>
                <style>
                    * { font-family: 'Poppins', sans-serif; text-align: center; margin: 0; padding: 0; }
                    body { display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh; background-color: #f4f4f4; }
                    .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
                    .checkmark { color: #007BFF; font-size: 50px; }
                    .btn { background: #007BFF; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 15px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='checkmark'>✅</div>
                    <h2>Appointment Booked Successfully!</h2>
                    <p>Thank you, $patient_name. Your appointment with Dr. $doctor_name on $appointment_date has been scheduled.</p>
                    <a href='appointment.php' class='btn'>Go Back</a>
                </div>
            </body>
            </html>";

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    } else {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
    }
} else {
    header("Location: appointment.php");
    exit();
}
?>

