<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $_SESSION['error_message'] = 'Username dan password wajib diisi.';
    header('Location: login.php');
    exit;
}

$stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();

    // =================================================================
    // KODE YANG DIPERBAIKI:
    // Membandingkan password yang diinput dengan password di database
    // sebagai teks biasa (plain text).
    // PERINGATAN: Metode ini tidak aman.
    // =================================================================
    if ($password === $admin['password']) {
        // Login berhasil
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $username;
        header('Location: dashboard.php');
        exit;
    }
}

// Jika login gagal
$_SESSION['error_message'] = 'Username atau password salah.';
header('Location: login.php');
exit;
?>
