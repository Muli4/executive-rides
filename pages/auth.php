<?php
include '../db.php';
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) { // Registration logic
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

        // Use prepared statement to prevent SQL Injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $message = "Email already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);
            
            if ($stmt->execute()) {
                $message = "Registration successful! Proceed to Log in";
            } else {
                $message = "Registration failed! " . $conn->error;
            }
        }
        $stmt->close();
    }

    if (isset($_POST["login"])) { // Login logic
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["role"] = $user["role"];
                header("Location: ../index.php"); // Corrected redirection
                exit();
            } else {
                $message = "Incorrect Password";
            }
        } else {
            $message = "User not found!";
        }
        $stmt->close();
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
<body class="form-body">
    <div class="container">
        <h2 class="form-title">Login</h2>
        <p><?php echo $message?></p>

        <form action="" id="login-form" method="POST">
            <label for="email">Email </label>
            <input type="email" name="email" id="email" placeholder="Enter email" required>
           
            <label for="password">Password </label>
            <input type="password" name="password" id="password" placeholder="Enter password" required>

            <button type="submit" name="login">Login</button>
            <p>Don't have an account? <button type="button" class="toggle-btn" onclick="toggleForm()">Register</button></p>
        </form>


        <form action="" id="register-form" method="POST" style="display: none;">
            <label for="name">Full name </label>
                <input type="text" name="name" placeholder="Enter Full Name" required>

            <label for="email"> </label>
                <input type="email" name="email" placeholder="Enter Email" required>

            <label for="password">Password </label>
                <input type="password" name="password" placeholder="Enter password" required>

            <button type="submit" name="register">Register</button>
            <p>Already have an account? <button type="button" class="toggle-btn" onclick="toggleForm()">Login</button></p>
        </form>
    </div>
</body>

<script src="../assets/js/main.js"></script>
</html>