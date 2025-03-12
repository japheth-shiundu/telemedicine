<?php
session_start();
include 'database.php'; // Database connection using PDO

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle Sign Up
if (isset($_POST['signup'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        $success = "Registration successful! You can now log in.";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle Sign In
if (isset($_POST['signin'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; text-align: center; background-color: #f4f4f4; }
        .container { width: 300px; margin: 50px auto; padding: 20px; background: white; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        input, button { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; }
        .hidden { display: none; }
        .toggle { cursor: pointer; color: #007BFF; }
    </style>
</head>
<body>
    <div class="container">
        <h2 id="form-title">Admin Login</h2>
        
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
        
        <form id="signin-form" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="signin">Sign In</button>
        </form>
        
        <form id="signup-form" method="post" class="hidden">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="signup">Sign Up</button>
        </form>
        
        <p class="toggle" onclick="toggleForms()">Don't have an account? Sign Up</p>
    </div>

    <script>
        function toggleForms() {
            var signinForm = document.getElementById("signin-form");
            var signupForm = document.getElementById("signup-form");
            var formTitle = document.getElementById("form-title");
            var toggleText = document.querySelector(".toggle");
            
            if (signinForm.classList.contains("hidden")) {
                signinForm.classList.remove("hidden");
                signupForm.classList.add("hidden");
                formTitle.innerText = "Admin Login";
                toggleText.innerText = "Don't have an account? Sign Up";
            } else {
                signinForm.classList.add("hidden");
                signupForm.classList.remove("hidden");
                formTitle.innerText = "Admin Sign Up";
                toggleText.innerText = "Already have an account? Sign In";
            }
        }
    </script>
</body>
</html>
