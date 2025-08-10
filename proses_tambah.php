<?php
require 'db_connect.php';

if (
    isset($_POST['nik'], $_POST['nama_lengkap'], $_POST['nomor_registrasi'], $_POST['alamat'],
          $_POST['jenis_bantuan_yang_diusulkan'], $_POST['kelompok'], $_POST['profesi'], $_POST['status'], $_POST['jenis_bantuan_yang_sudah_diterima'])
) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama_lengkap'];
    $no_reg = $_POST['nomor_registrasi'];
    $alamat = $_POST['alamat'];
    $jenis_bantuan_yang_diusulkan = $_POST['jenis_bantuan_yang_diusulkan'];
    $kelompok = $_POST['kelompok'];
    $profesi = $_POST['profesi'];
    $status = $_POST['status'];
    $jenis_bantuan_sudah = $_POST['jenis_bantuan_yang_sudah_diterima'];

    // Cek apakah NIK sudah ada
    $cek = $conn->prepare("SELECT nik FROM anggota WHERE nik = ?");
    $cek->bind_param("s", $nik);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo "<script>alert('NIK sudah terdaftar!'); window.location.href='tambah_anggota.php';</script>";
        exit;
    }
    $cek->close();

    // Simpan data jika NIK belum ada
    $stmt = $conn->prepare("INSERT INTO anggota (nik, nama_lengkap, nomor_registrasi, alamat, jenis_bantuan_yang_diusulkan, kelompok, profesi, status, jenis_bantuan_yang_sudah_diterima) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $nik, $nama, $no_reg, $alamat, $jenis_bantuan_yang_diusulkan, $kelompok, $profesi, $status, $jenis_bantuan_sudah);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Gagal menyimpan data: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Semua field harus diisi.";
}

$conn->close();
?>
