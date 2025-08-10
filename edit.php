<?php
require 'db_connect.php';

// Proteksi halaman
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

// Ambil data anggota yang akan diedit
$stmt = $conn->prepare("SELECT * FROM anggota WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "Data tidak ditemukan.";
    exit;
}
$anggota = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Anggota</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container form-box">
        <div class="form-header">
            <a href="dashboard.php" class="btn-back">&larr; Kembali ke Dashboard</a>
            <h2>Edit Anggota</h2>
        </div>

        <form action="proses_edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">

            <div class="input-group">
                <label for="nik">NIK</label>
                <!-- PERUBAHAN: Ditambahkan oninput untuk memfilter karakter non-angka secara real-time -->
                <input type="text" id="nik" name="nik" value="<?php echo htmlspecialchars($anggota['nik']); ?>" pattern="[0-9]*" title="Input hanya boleh berisi angka." oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
            </div>
            <div class="input-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <!-- PERUBAHAN: Ditambahkan oninput untuk memfilter karakter selain huruf dan spasi -->
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($anggota['nama_lengkap']); ?>" pattern="[a-zA-Z\s]+" title="Input hanya boleh berisi huruf dan spasi." oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
            </div>
            <div class="input-group">
                <label for="nomor_registrasi">Nomor Registrasi</label>
                <!-- PERUBAHAN: Ditambahkan pattern dan oninput untuk memfilter karakter non-angka -->
                <input type="text" id="nomor_registrasi" name="nomor_registrasi" value="<?php echo htmlspecialchars($anggota['nomor_registrasi']); ?>" pattern="[0-9]*" title="Input hanya boleh berisi angka." oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
            <div class="input-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3"><?php echo htmlspecialchars($anggota['alamat']); ?></textarea>
            </div>
            <div class="input-group">
                <label for="jenis_bantuan">Jenis Bantuan</label>
                <input type="text" id="jenis_bantuan" name="jenis_bantuan" value="<?php echo htmlspecialchars($anggota['jenis_bantuan']); ?>">
            </div>
            <div class="input-group">
                <label for="kelompok">Kelompok</label>
                <input type="text" id="kelompok" name="kelompok" value="<?php echo htmlspecialchars($anggota['kelompok']); ?>" required>
            </div>
            <div class="input-group">
                <label for="profesi">Profesi</label>
                <!-- Dropdown dengan pilihan yang sesuai data lama -->
                <select id="profesi" name="profesi" class="input-group" style="width:100%; padding:12px; border: 1px solid #b0bec5; border-radius: 8px;">
                    <option value="Anggota" <?php if($anggota['profesi'] == 'Anggota') echo 'selected'; ?>>Anggota</option>
                    <option value="Ketua" <?php if($anggota['profesi'] == 'Ketua') echo 'selected'; ?>>Ketua</option>
                </select>
            </div>
            <div class="input-group">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="4"><?php echo htmlspecialchars($anggota['keterangan']); ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Data</button>
        </form>
    </div>
</body>
</html>
