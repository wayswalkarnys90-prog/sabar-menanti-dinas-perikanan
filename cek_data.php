<?php
$anggota = null;
$search_message = '';

if (isset($_GET['nik']) && !empty(trim($_GET['nik']))) {
    require 'db_connect.php';
    $nik_input = trim(preg_replace('/[^0-9]/', '', $_GET['nik']));

    // --- VALIDASI AWAL ---
    if ($nik_input === '') {
        $search_message = "NIK tidak valid.";
    // --- VALIDASI PANJANG NIK (BATAS 20 KARAKTER) ---
    } elseif (strlen($nik_input) > 20) {
        $search_message = "NIK tidak boleh lebih dari 20 digit.";
    // --- JIKA VALIDASI LOLOS, LANJUTKAN KE DATABASE ---
    } else {
        $stmt = $conn->prepare("SELECT nik, nama_lengkap, nomor_registrasi, alamat, jenis_bantuan_yang_diusulkan, kelompok, profesi, status, jenis_bantuan_yang_sudah_diterima AS keterangan FROM anggota WHERE nik = ?");
        $stmt->bind_param("s", $nik_input);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $anggota = $result->fetch_assoc();
        } else {
            $search_message = "Data NIK yang Anda cari belum terdaftar.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cek Data - SABAR MENANTI</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('assets/p.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 900px;
      margin: 40px auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      overflow-x: hidden;
      word-break: break-word;
    }
    .main-header {
      text-align: center;
      margin-bottom: 20px;
    }
    .main-header h1 {
      margin: 0;
    }
    .search-box {
      text-align: center;
      margin-bottom: 20px;
    }
    .search-box input {
      padding: 8px;
      width: 60%;
      max-width: 300px;
    }
    .search-box button {
      padding: 8px 15px;
      margin-left: 5px;
    }
    .result-box {
      padding: 15px;
      border-radius: 8px;
      margin-top: 15px;
    }
    .result-box.success {
      background-color: #e6ffed;
      border: 1px solid #8fd19e;
    }
    .result-box.error {
      background-color: #ffeaea;
      border: 1px solid #ff9999;
    }
    .result-item {
      display: grid;
      grid-template-columns: 200px 1fr;
      padding: 8px 0;
      border-bottom: 1px solid #ddd;
      align-items: start;
    }
    .label {
      font-weight: bold;
      overflow-wrap: break-word;
      word-break: break-word;
    }
    .value {
      overflow-wrap: break-word;
      word-break: break-word;
      white-space: pre-wrap;
    }
    .btn-back {
      display: inline-block;
      padding: 8px 15px;
      background: #3498db;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }
    .btn-back:hover {
      background: #217dbb;
    }
  </style>
</head>
<body>
  <div class="container">
    <header class="main-header">
      <h1>Sabar Menanti</h1>
      <p>Dinas Perikanan</p>
    </header>

    <div class="search-box">
      <form action="cek_data.php" method="GET">
        <label for="nik">Cek Data NIK</label><br>
        <input type="text" id="nik" name="nik" placeholder="Masukkan NIK Anda di sini..." required
          value="<?php echo isset($_GET['nik']) ? htmlspecialchars($_GET['nik']) : ''; ?>"
          pattern="[0-9]*" title="Input hanya boleh berisi angka." 
          maxlength="20"
          oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        <button type="submit">Cari</button>
      </form>
    </div>

    <div id="result-container">
      <?php if ($anggota): ?>
        <div class="result-box success">
          <h2>Data Ditemukan</h2>
          <div class="result-item"><span class="label">NIK:</span><span class="value"><?php echo htmlspecialchars($anggota['nik']); ?></span></div>
          <div class="result-item"><span class="label">Nama Lengkap:</span><span class="value"><?php echo htmlspecialchars($anggota['nama_lengkap']); ?></span></div>
          <div class="result-item"><span class="label">No. Registrasi:</span><span class="value"><?php echo htmlspecialchars($anggota['nomor_registrasi']); ?></span></div>
          <div class="result-item"><span class="label">Alamat:</span><span class="value"><?php echo htmlspecialchars($anggota['alamat']); ?></span></div>
          <div class="result-item"><span class="label">Jenis Bantuan yang Diusulkan:</span><span class="value"><?php echo htmlspecialchars($anggota['jenis_bantuan_yang_diusulkan']); ?></span></div>
          <div class="result-item"><span class="label">Kelompok:</span><span class="value"><?php echo htmlspecialchars($anggota['kelompok']); ?></span></div>
          <div class="result-item"><span class="label">Profesi:</span><span class="value"><?php echo htmlspecialchars($anggota['profesi']); ?></span></div>
          <div class="result-item"><span class="label">Status:</span><span class="value"><?php echo htmlspecialchars($anggota['status']); ?></span></div>
          <div class="result-item"><span class="label">Jenis Bantuan yang Sudah Diterima:</span><span class="value"><?php echo nl2br(htmlspecialchars($anggota['keterangan'])); ?></span></div>
        </div>
      <?php elseif ($search_message): ?>
        <div class="result-box error">
          <p><?php echo $search_message; ?></p>
        </div>
      <?php endif; ?>
    </div>

    <div class="back-button" style="text-align:center; margin-top:30px;">
      <a href="index.php" class="btn-back">← Kembali ke Home</a>
    </div>
  </div>

  <script>
    document.getElementById("nik").addEventListener("input", function() {
      const resultContainer = document.getElementById("result-container");
      if (this.value.trim() === "") {
        resultContainer.innerHTML = ""; // Kosongkan hasil jika input kosong
      }
    });
  </script>
</body>
</html>