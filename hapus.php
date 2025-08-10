<?php
session_start();
require 'db_connect.php';

// Cek login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Validasi NIK
if (isset($_GET['nik']) && !empty($_GET['nik'])) {
    $nik = $_GET['nik'];

    $stmt = $conn->prepare("DELETE FROM anggota WHERE nik = ?");
    $stmt->bind_param("s", $nik);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Data anggota berhasil dihapus.";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus data.";
    }

    $stmt->close();
} else {
    $_SESSION['error_message'] = "NIK tidak valid.";
}

header('Location: dashboard.php');
exit;
?>
