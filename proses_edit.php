<?php
session_start();
require 'db_connect.php';

// Cek login & method
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

// Ambil data dari form
$nik_baru = $_POST['nik']; // NIK yang baru
$nik_lama = $_POST['nik_lama']; // NIK lama (hidden input)
$nama_lengkap = $_POST['nama_lengkap'];
$nomor_registrasi = $_POST['nomor_registrasi'];
$alamat = $_POST['alamat'];
$jenis_bantuan_yang_diusulkan = $_POST['jenis_bantuan_yang_diusulkan'];
$kelompok = $_POST['kelompok'];
$profesi = $_POST['profesi'];
$status = $_POST['status'];
$jenis_bantuan_yang_sudah_diterima = $_POST['jenis_bantuan_yang_sudah_diterima'];

// Update query termasuk NIK
$sql = "UPDATE anggota 
        SET nik=?, nama_lengkap=?, nomor_registrasi=?, alamat=?, jenis_bantuan_yang_diusulkan=?, kelompok=?, profesi=?, status=?, jenis_bantuan_yang_sudah_diterima=?
        WHERE nik=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssss", $nik_baru, $nama_lengkap, $nomor_registrasi, $alamat, $jenis_bantuan_yang_diusulkan, $kelompok, $profesi, $status, $jenis_bantuan_yang_sudah_diterima, $nik_lama);

// Eksekusi
if ($stmt->execute()) {
    header('Location: dashboard.php');
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
