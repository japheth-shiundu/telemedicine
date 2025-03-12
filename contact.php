<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Poppins', sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; text-align: center;">

    <header style="background: #007BFF; color: white; padding: 15px 0;">
        <h1>Contact Us</h1>
        <nav>
            <a href="index.php" style="margin: 0 15px; color: white; text-decoration: none;">Home</a>
            <a href="doctors.php" style="margin: 0 15px; color: white; text-decoration: none;">Find a Doctor</a>
            <a href="appointment.php" style="margin: 0 15px; color: white; text-decoration: none;">Book Appointment</a>
            <a href="contact.php" style="margin: 0 15px; color: white; text-decoration: none;">Contact</a>
        </nav>
    </header>

    <section style="width: 90%; max-width: 400px; margin: 20px auto; padding: 20px; background: white; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: left;">
        <h2 style="text-align: center;">Get in Touch</h2>
        
        <form action="send_message.php" method="post" style="display: flex; flex-direction: column;">
            <label for="name" style="font-weight: bold; margin-bottom: 5px;">Your Name:</label>
            <input type="text" id="name" name="name" required style="padding: 10px; width: 100%; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px;">

            <label for="email" style="font-weight: bold; margin-bottom: 5px;">Email Address:</label>
            <input type="email" id="email" name="email" required style="padding: 10px; width: 100%; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px;">

            <label for="message" style="font-weight: bold; margin-bottom: 5px;">Message:</label>
            <textarea id="message" name="message" required style="padding: 10px; width: 100%; height: 100px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px;"></textarea>

            <button type="submit" style="background: #007BFF; color: white; padding: 12px; border: none; border-radius: 5px; width: 100%; cursor: pointer; font-size: 16px;">Send Message</button>
        </form>
    </section>

    <footer style="background: #333; color: white; padding: 10px;">
        <p>&copy; 2025 Telemedicine Exchange. All Rights Reserved.</p>
    </footer>

</body>
</html>
