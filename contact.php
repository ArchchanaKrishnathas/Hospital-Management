<?php
session_start();

// Database connection details
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
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Validate input fields
    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: index.html");
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format!";
        header("Location: index.html");
        exit();
    }

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO contact_us (full_name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Message sent successfully!";
    } else {
        $_SESSION['error'] = "Failed to send message!";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to index.html
    header("Location: index.html");
    exit();
}
?>
