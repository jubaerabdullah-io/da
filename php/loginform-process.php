<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Fetch user
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_email'] = $email;
            // ✅ Same behavior, no blank "Redirecting..." page
            echo "<script>window.location.href='../index.html';</script>";
            exit;
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Email not found. Please sign up.";
    }

    $stmt->close();
    $conn->close();
} else {
    die("Invalid request");
}
?>
