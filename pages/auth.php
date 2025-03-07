<?php
include '../config/db.php';
session_start();

$message = "";

// Display stored session message
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear message after displaying
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $password = password_hash(trim($_POST["password"]), PASSWORD_BCRYPT);

        $check_email = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($check_email);

        if ($result->num_rows > 0) {
            $_SESSION['message'] = "<p class='alert error'>Email already exists!</p>";
        } else {
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['message'] = "<p class='alert success'>Registration successful! Please log in.</p>";
            } else {
                $_SESSION['message'] = "<p class='alert error'>Registration failed: " . $conn->error . "</p>";
            }
        }

        // Redirect to prevent form resubmission
        header("Location: auth.php");
        exit();
    }

    if (isset($_POST["login"])) {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["role"] = $user["role"];
                header("Location: ../index.php");
                exit();
            } else {
                $_SESSION['message'] = "<p class='alert error'>Incorrect password</p>";
            }
        } else {
            $_SESSION['message'] = "<p class='alert error'>User not found!</p>";
        }

        // Redirect to prevent resubmission
        header("Location: auth.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-box">
        
        <!-- Display Session Message -->
        <?php if (!empty($message)) echo "<div class='message-box'>$message</div>"; ?>

        <!-- Login Form -->
        <form action="" id="login-form" method="POST">
            <h2>Login</h2>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" name="login" class="btn">Login</button>
            <p>Don't have an account? <a href="#" onclick="toggleForm()">Register</a></p>
        </form>

        <!-- Register Form -->
        <form action="" id="register-form" method="POST" style="display: none;">
            <h2>Register</h2>
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" name="register" class="btn">Register</button>
            <p>Already have an account? <a href="#" onclick="toggleForm()">Login</a></p>
        </form>

    </div>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
