<?php
session_start();
$servername = "localhost";
$username = "root"; // Change this if needed
$password = ""; // Change if using a password
$dbname = "arc_hospital";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $pass = trim($_POST["password"]);
    $confirm_pass = trim($_POST["confirm_pw"]);

    // Validate input fields
    if (empty($user) || empty($email) || empty($pass) || empty($confirm_pass)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: adminRegister.html");
        exit();
    }

    // Check if passwords match
    if ($pass !== $confirm_pass) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: adminRegister.html");
        exit();
    }

    // Hash password for security
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! Please log in.";
        header("Location: adminLogin.html");
        exit();
    } else {
        $_SESSION['error'] = "Registration failed!";
        header("Location: adminRegister.html");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
