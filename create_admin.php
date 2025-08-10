<?php
require 'db_connect.php';

echo "<pre>"; // Untuk tampilan yang lebih rapi

$username = 'admin';
$password = 'admin123'; // Ganti dengan password yang aman

// Menggunakan password_hash untuk keamanan
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Cek jika username sudah ada
$stmt_check = $conn->prepare("SELECT id FROM admins WHERE username = ?");
$stmt_check->bind_param("s", $username);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    die("Error: Username '$username' sudah terdaftar.");
}
$stmt_check->close();

// Masukkan admin baru
$stmt_insert = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt_insert->bind_param("ss", $username, $hashed_password);

if ($stmt_insert->execute()) {
    echo "Admin berhasil dibuat!\n";
    echo "Username: " . htmlspecialchars($username) . "\n";
    echo "Password: " . htmlspecialchars($password) . "\n\n";
    echo "Harap hapus file 'create_admin.php' ini dari server Anda setelah selesai.";
} else {
    echo "Error saat membuat admin: " . $stmt_insert->error;
}

$stmt_insert->close();
$conn->close();
echo "</pre>";