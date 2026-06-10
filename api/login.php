<?php
session_start();

// Include config
require_once __DIR__ . '/../config/config.php';

// Jika request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        header('Location: ../public/login.php?error=Username dan password harus diisi');
        exit;
    }

    // Hash password
    $password_hash = hash('sha256', $password);

    // Query ke database
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password_hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['login_time'] = time();

        // Redirect ke dashboard
        header('Location: ../public/dashboard.php');
        exit;
    } else {
        header('Location: ../public/login.php?error=Username atau password salah');
        exit;
    }
}

// Jika bukan POST, redirect ke login
header('Location: ../public/login.php');
exit;
?>
