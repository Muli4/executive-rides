<?php
include '../db.php';
session_start();

$message = "";

// Check if there's a stored message in the session
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear message after displaying it
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

        $check_email = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($check_email);

        if ($result->num_rows > 0) {
            $_SESSION['message'] = "<div class='alert error'>Email already exists!</div>";
        } else {
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
            if ($conn->query($sql) === true) {
                $_SESSION['message'] = "<div class='alert success'>Registration successful! Proceed to Log in.</div>";
            } else {
                $_SESSION['message'] = "<div class='alert error'>Registration failed! " . $conn->error . "</div>";
            }
        }

        // Redirect to prevent resubmission
        header("Location: auth.php");
        exit();
    }

    if (isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

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
                $_SESSION['message'] = "<div class='alert error'>Incorrect Password</div>";
            }
        } else {
            $_SESSION['message'] = "<div class='alert error'>User not found!</div>";
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
<body class="form-body">
    <div class="container">

        <form action="" id="login-form" method="POST">
            <h2 class="form-title">Login</h2>
            <?php echo $message?>
            <label for="email">Email </label>
            <input type="email" name="email" id="email" placeholder="Enter email" required>
           
            <label for="password">Password </label>
            <input type="password" name="password" id="password" placeholder="Enter password" required>

            <button type="submit" name="login">Login</button>
            <p>Don't have an account? <button type="button" class="toggle-btn" onclick="toggleForm()">Register</button></p>
        </form>


        <form action="" id="register-form" method="POST" style="display: none;">
             <h2 class="form-title">Register</h2>
             <?php echo $message?>
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