<?php
require 'db_connect.php';

// Proteksi halaman
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Anggota Baru</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container form-box">
        <div class="form-header">
            <a href="dashboard.php" class="btn-back">&larr; Kembali ke Dashboard</a>
            <h2>Tambah Anggota</h2>
        </div>

        <form action="proses_tambah.php" method="post">
            <div class="input-group">
                <label for="nik">NIK</label>
                <!-- PERUBAHAN: Ditambahkan oninput untuk memfilter karakter non-angka secara real-time -->
                <input type="text" id="nik" name="nik" pattern="[0-9]*" title="Input hanya boleh berisi angka." oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
            </div>
            <div class="input-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <!-- PERUBAHAN: Ditambahkan oninput untuk memfilter karakter selain huruf dan spasi -->
                <input type="text" id="nama_lengkap" name="nama_lengkap" pattern="[a-zA-Z\s]+" title="Input hanya boleh berisi huruf dan spasi." oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
            </div>
            <div class="input-group">
                <label for="nomor_registrasi">Nomor Registrasi</label>
                <!-- PERUBAHAN: Ditambahkan pattern dan oninput untuk memfilter karakter non-angka -->
                <input type="text" id="nomor_registrasi" name="nomor_registrasi" pattern="[0-9]*" title="Input hanya boleh berisi angka." oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
            <div class="input-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3"></textarea>
            </div>
            <div class="input-group">
                <label for="jenis_bantuan">Jenis Bantuan</label>
                <input type="text" id="jenis_bantuan" name="jenis_bantuan">
            </div>
            <div class="input-group">
                <label for="kelompok">Kelompok</label>
                <input type="text" id="kelompok" name="kelompok" required>
            </div>
            <div class="input-group">
                <label for="profesi">Profesi</label>
                <!-- Diubah menjadi dropdown/pilihan -->
                <select id="profesi" name="profesi" class="input-group" style="width:100%; padding:12px; border: 1px solid #b0bec5; border-radius: 8px;">
                    <option value="Anggota">Anggota</option>
                    <option value="Ketua">Ketua</option>
                </select>
            </div>
            <div class="input-group">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="4"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
    </div>
<body style="background: url('assets/Pantai.jpg') no-repeat center center fixed; background-size: cover;">
</html>
