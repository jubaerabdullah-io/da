<?php
session_start();
include 'db.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $terms = isset($_POST['terms']) ? $_POST['terms'] : '';

    if ($terms !== "Agreed-to-Terms") {
        die("You must agree to the terms.");
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        die("Email already registered. Please log in.");
    }
    $stmt->close();

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashedPassword);
    if ($stmt->execute()) {
        $_SESSION['user_email'] = $email;
        // ✅ Same behavior, no blank "Redirecting..." page
        echo "<script>window.location.href='../log-in.html';</script>";
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    die("Invalid request");
}
?>
