<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "arc_hospital";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $pass = trim($_POST["password"]);
    $confirm_pass = trim($_POST["confirm_pw"]);

    // Validate inputs
    if (empty($username) || empty($email) || empty($pass) || empty($confirm_pass)) {
        echo "<script>alert('All fields are required!'); window.location.href='patientRegister.html';</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!'); window.location.href='patientRegister.html';</script>";
        exit();
    }

    if ($pass !== $confirm_pass) {
        echo "<script>alert('Passwords do not match!'); window.location.href='patientRegister.html';</script>";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO patient (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='../PatientLogin/patientLogin.html';</script>";
    } else {
        echo "<script>alert('Error: Email or Username already exists!'); window.location.href='patientRegister.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
