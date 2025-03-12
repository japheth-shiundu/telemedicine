<?php
require 'admin-panel/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO messages (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $message]);
            $success = "✅ Message sent successfully!";
        } catch (PDOException $e) {
            $error = "❌ Database error: " . $e->getMessage();
        }
    } else {
        $error = "❌ All fields are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send a Message</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Poppins', sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; text-align: center;">

    <header style="background: #007BFF; color: white; padding: 15px 0;">
        <h1>Send a Message</h1>
        <nav>
            <a href="index.php" style="margin: 0 15px; color: white; text-decoration: none;">Home</a>
            <a href="contact.php" style="margin: 0 15px; color: white; text-decoration: none;">Contact</a>
        </nav>
    </header>

    <section style="width: 90%; max-width: 400px; margin: 20px auto; padding: 20px; background: white; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: left;">
        <h2 style="text-align: center;">Send Us a Message</h2>

        <?php if (isset($success)): ?>
            <p style="color: green; text-align: center;"><?= htmlspecialchars($success); ?></p>
        <?php elseif (isset($error)): ?>
            <p style="color: red; text-align: center;"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="send_message.php" method="post" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
            <label for="name" style="margin-top: 10px; font-weight: bold; width: 100%;">Your Name:</label>
            <input type="text" id="name" name="name" required 
                style="padding: 10px; width: 90%; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">

            <label for="email" style="margin-top: 10px; font-weight: bold; width: 100%;">Your Email:</label>
            <input type="email" id="email" name="email" required 
                style="padding: 10px; width: 90%; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">

            <label for="message" style="margin-top: 10px; font-weight: bold; width: 100%;">Your Message:</label>
            <textarea id="message" name="message" rows="4" required 
                style="padding: 10px; width: 90%; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;"></textarea>

            <button type="submit" 
                style="margin-top: 15px; background: #007BFF; color: white; padding: 12px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; width: 90%;">
                Send Message
            </button>
        </form>
    </section>

    <footer style="background: #333; color: white; padding: 10px;">
        <p>&copy; 2025 Telemedicine Exchange. All Rights Reserved.</p>
    </footer>

</body>
</html>
