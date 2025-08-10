<?php
require 'db_connect.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['nik'])) {
    header('Location: dashboard.php');
    exit;
}

$nik = $_GET['nik'];
$stmt = $conn->prepare("SELECT * FROM anggota WHERE nik = ?");
$stmt->bind_param("s", $nik);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Anggota</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background: url('assets/0.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }
        /* Style untuk input yang tidak valid */
        .invalid-input {
            border-color: #ef4444 !important; /* Merah */
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.3);
        }
    </style>
</head>
<body class="min-h-screen py-10 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="form-container p-8 md:p-10">
            <div class="flex justify-between items-center mb-8">
                <a href="dashboard.php" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                    ← Kembali ke Dashboard
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Edit Data Anggota</h1>
            </div>

            <form id="editForm" action="proses_edit.php" method="post" class="space-y-6">
                <input type="hidden" name="nik_lama" value="<?= htmlspecialchars($data['nik']) ?>">

                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                    <input type="text" id="nik" name="nik" required
                           value="<?= htmlspecialchars($data['nik']) ?>"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500"
                           minlength="16"
                           maxlength="16"
                           pattern="\d{16}"
                           title="NIK harus terdiri dari 16 digit angka."
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                    <p class="text-red-500 text-xs mt-1 hidden" id="nikError">NIK harus terdiri dari 16 digit angka.</p>
                </div>

                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" required
                           value="<?= htmlspecialchars($data['nama_lengkap']) ?>"
                           pattern="[a-zA-Z\s]+"
                           oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500" />
                </div>

                <div>
                    <label for="nomor_registrasi" class="block text-sm font-medium text-gray-700 mb-1">Nomor Registrasi</label>
                    <input type="text" name="nomor_registrasi" required
                        value="<?= htmlspecialchars($data['nomor_registrasi']) ?>"
                        pattern="[a-zA-Z0-9\s\-]+"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500" />
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="alamat" rows="3" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500"><?= htmlspecialchars($data['alamat']) ?></textarea>
                </div>

                <div>
                    <label for="jenis_bantuan_yang_diusulkan" class="block text-sm font-medium text-gray-700 mb-1">Jenis Bantuan yang Diusulkan</label>
                    <input type="text" name="jenis_bantuan_yang_diusulkan" required
                        value="<?= htmlspecialchars($data['jenis_bantuan_yang_diusulkan']) ?>"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500" />
                </div>

                <div>
                    <label for="kelompok" class="block text-sm font-medium text-gray-700 mb-1">Kelompok</label>
                    <input type="text" name="kelompok" required
                        value="<?= htmlspecialchars($data['kelompok']) ?>"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500" />
                </div>

                <div>
                    <label for="profesi" class="block text-sm font-medium text-gray-700 mb-1">Profesi</label>
                    <select name="profesi" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Profesi --</option>
                        <option value="Nelayan" <?= $data['profesi'] == 'Nelayan' ? 'selected' : '' ?>>Nelayan</option>
                        <option value="Pembudi Daya" <?= $data['profesi'] == 'Pembudi Daya' ? 'selected' : '' ?>>Pembudi Daya</option>
                        <option value="Pengolahan dan Pemasaran Ikan" <?= $data['profesi'] == 'Pengolahan dan Pemasaran Ikan' ? 'selected' : '' ?>>Pengolahan dan Pemasaran Ikan</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status dalam Kelompok</label>
                    <select name="status" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Status --</option>
                        <option value="Ketua" <?= $data['status'] == 'Ketua' ? 'selected' : '' ?>>Ketua</option>
                        <option value="Anggota" <?= $data['status'] == 'Anggota' ? 'selected' : '' ?>>Anggota</option>
                    </select>
                </div>

                <div>
                    <label for="jenis_bantuan_yang_sudah_diterima" class="block text-sm font-medium text-gray-700 mb-1">Jenis Bantuan yang Sudah Diterima</label>
                    <textarea name="jenis_bantuan_yang_sudah_diterima" rows="3"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500"><?= htmlspecialchars($data['jenis_bantuan_yang_sudah_diterima']) ?></textarea>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
// Skrip sederhana untuk validasi form saat submit
document.getElementById('editForm').addEventListener('submit', function(event) {
    let isValid = true;
    const inputs = this.querySelectorAll('[required]');
    
    inputs.forEach(input => {
        // Hapus style error sebelumnya
        input.classList.remove('invalid-input');
        const errorEl = document.getElementById(input.id + 'Error');
        if(errorEl) errorEl.classList.add('hidden');

        // Lakukan validasi
        if (!input.checkValidity()) {
            isValid = false;
            input.classList.add('invalid-input');
            
            // Tampilkan pesan error jika ada
            if(errorEl) errorEl.classList.remove('hidden');
            
            // Contoh pesan error spesifik untuk NIK
            if(input.id === 'nik') {
                console.log('NIK tidak valid:', input.value);
            }
        }
    });

    if (!isValid) {
        event.preventDefault(); // Hentikan submit jika form tidak valid
        alert('Pastikan semua kolom yang wajib diisi telah sesuai format.');
    }
});
</script>

</body>
</html>