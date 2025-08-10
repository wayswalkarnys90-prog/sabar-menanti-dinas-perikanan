<?php
// Tidak perlu session_start() karena halaman ini publik

// Variabel untuk menampung hasil pencarian atau pesan error
$anggota = null;
$search_message = '';

// Cek apakah form sudah disubmit dengan NIK
if (isset($_GET['nik']) && !empty(trim($_GET['nik']))) {
    require 'db_connect.php'; // Hubungkan ke DB hanya saat diperlukan

    $nik_input = trim($_GET['nik']);

    $stmt = $conn->prepare("SELECT nik, nama_lengkap, nomor_registrasi, alamat, jenis_bantuan, kelompok, profesi, keterangan FROM anggota WHERE nik = ?");
    $stmt->bind_param("s", $nik_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $anggota = $result->fetch_assoc();
    } else {
        $search_message = "Data dengan NIK tersebut tidak ditemukan.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Data Anggota - Sabar Menanti</title>
    <link rel="stylesheet" href="assets/user_style.css">
</head>
<body>
    <div class="container">
        <header class="main-header">
            <h1>Sabar Menanti</h1>
            <p>Sistem Informasi Kelompok dan Tugas</p>
        </header>

        <div class="search-box">
            <form action="index.php" method="GET">
                <label for="nik">Cek Data Anda</label>
                <!-- ================================================================= -->
                <!-- PERUBAHAN DI SINI: Ditambahkan oninput untuk validasi real-time -->
                <!-- ================================================================= -->
                <input type="text" id="nik" name="nik" placeholder="Masukkan NIK Anda di sini..." required 
                       value="<?php echo isset($_GET['nik']) ? htmlspecialchars($_GET['nik']) : ''; ?>"
                       pattern="[0-9]*" title="Input hanya boleh berisi angka." 
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                <button type="submit">Cari</button>
            </form>
        </div>

        <?php if ($anggota): ?>
            <div id="result-container" class="result-box success">
                <h2>Data Ditemukan</h2>
                <div class="result-item">
                    <span class="label">NIK:</span>
                    <span class="value"><?php echo htmlspecialchars($anggota['nik']); ?></span>
                </div>
                <div class="result-item">
                    <span class="label">Nama Lengkap:</span>
                    <span class="value"><?php echo htmlspecialchars($anggota['nama_lengkap']); ?></span>
                </div>
                <div class="result-item">
                    <span class="label">No. Registrasi:</span>
                    <span class="value"><?php echo htmlspecialchars($anggota['nomor_registrasi']); ?></span>
                </div>
                <div class="result-item">
                    <span class="label">Alamat:</span>
                    <span class="value"><?php echo htmlspecialchars($anggota['alamat']); ?></span>
                </div>
                <div class="result-item">
                    <span class="label">Jenis Bantuan:</span>
                    <span class="value"><?php echo htmlspecialchars($anggota['jenis_bantuan']); ?></span>
                </div>
                <div class="result-item">
                    <span class="label">Kelompok:</span>
                    <span class="value"><?php echo htmlspecialchars($anggota['kelompok']); ?></span>
                </div>
                <div class="result-item">
                    <span class="label">Profesi:</span>
                    <span class="value"><?php echo htmlspecialchars($anggota['profesi']); ?></span>
                </div>
                <div class="result-item">
                    <span class="label">Keterangan:</span>
                    <span class="value task"><?php echo nl2br(htmlspecialchars($anggota['keterangan'])); ?></span>
                </div>
            </div>
        <?php elseif ($search_message): ?>
            <div id="result-container" class="result-box error">
                <p><?php echo $search_message; ?></p>
            </div>
        <?php endif; ?>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            const resultContainer = document.getElementById('result-container');

            if (resultContainer) {
                nikInput.addEventListener('input', function() {
                    if (nikInput.value.trim() === '') {
                        resultContainer.style.display = 'none';
                    }
                });
            }
        });
    </script>
<body style="background: url('assets/pantai.jpg') no-repeat center center fixed; background-size: cover;">
</html>
