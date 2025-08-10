<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

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

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        .invalid-input {
            border-color: #f87171 !important;
        }

        .error-message {
            color: #ef4444; /* Warna error lebih kontras */
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="min-h-screen py-10 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="form-container p-8 md:p-10">
            <div class="flex justify-between items-center mb-8">
                <a href="dashboard.php" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke Dashboard
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Anggota Baru</h1>
            </div>

            <form id="memberForm" action="proses_tambah.php" method="post" class="space-y-6" novalidate>
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" id="nik" name="nik"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 input-field focus:outline-none focus:border-blue-500"
                           required
                           minlength="16" 
                           maxlength="16"
                           pattern="\d{16}"
                           title="NIK harus terdiri dari 16 digit angka."
                           oninput="validateNumberInput(this)"
                           placeholder="Masukkan 16 digit NIK">
                    <p class="error-message hidden" id="nikError">NIK harus terdiri dari 16 digit angka.</p>
                </div>

                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 input-field focus:outline-none focus:border-blue-500"
                           required
                           pattern="[a-zA-Z\s]+"
                           oninput="validateLetterInput(this)"
                           placeholder="Masukkan nama lengkap">
                    <p class="error-message hidden" id="nama_lengkapError">Nama hanya boleh mengandung huruf dan spasi</p>
                </div>
                
                <div>
                    <label for="nomor_registrasi" class="block text-sm font-medium text-gray-700 mb-1">Nomor Registrasi</label>
                    <input type="text" id="nomor_registrasi" name="nomor_registrasi"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 input-field focus:outline-none focus:border-blue-500"
                           required
                           pattern="[a-zA-Z0-9\s\-]+"
                           placeholder="Masukkan nomor registrasi">
                    <p class="error-message hidden" id="nomor_registrasiError">Nomor registrasi hanya boleh huruf, angka, spasi, dan tanda hubung</p>
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" rows="3"
                              class="w-full px-4 py-2 rounded-lg border border-gray-300 input-field focus:outline-none focus:border-blue-500"
                              required
                              placeholder="Masukkan alamat lengkap"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="jenis_bantuan_yang_diusulkan" class="block text-sm font-medium text-gray-700 mb-1">Jenis Bantuan yang Diusulkan</label>
                        <input type="text" id="jenis_bantuan_yang_diusulkan" name="jenis_bantuan_yang_diusulkan"
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 input-field focus:outline-none focus:border-blue-500"
                               required
                               placeholder="Jenis bantuan yang diusulkan">
                    </div>

                    <div>
                        <label for="kelompok" class="block text-sm font-medium text-gray-700 mb-1">Kelompok</label>
                        <input type="text" id="kelompok" name="kelompok"
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 input-field focus:outline-none focus:border-blue-500"
                               required
                               placeholder="Nama kelompok">
                    </div>
                </div>

                <div>
                    <label for="profesi" class="block text-sm font-medium text-gray-700 mb-1">Profesi</label>
                    <select id="profesi" name="profesi"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 input-field focus:outline-none focus:border-blue-500"
                            required>
                        <option value="" selected disabled>-- Pilih Profesi --</option>
                        <option value="Nelayan">Nelayan</option>
                        <option value="Pembudi Daya">Pembudi Daya</option>
                        <option value="Pengolahan dan Pemasaran Ikan">Pengolahan dan Pemasaran Ikan</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status dalam Kelompok</label>
                    <select id="status" name="status"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 input-field focus:outline-none focus:border-blue-500"
                            required>
                        <option value="" selected disabled>-- Pilih Status --</option>
                        <option value="Ketua">Ketua</option>
                        <option value="Anggota">Anggota</option>
                    </select>
                </div>

                <div>
                    <label for="jenis_bantuan_yang_sudah_diterima" class="block text-sm font-medium text-gray-700 mb-1">Jenis Bantuan yang Sudah Diterima</label>
                    <textarea id="jenis_bantuan_yang_sudah_diterima" name="jenis_bantuan_yang_sudah_diterima" rows="3"
                              class="w-full px-4 py-2 rounded-lg border border-gray-300 input-field focus:outline-none focus:border-blue-500"
                              placeholder="Jenis bantuan yang sudah diterima (jika ada)"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Simpan Data Anggota
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fungsi ini hanya membersihkan input agar selalu angka, tidak lagi menangani validasi error secara langsung
        function validateNumberInput(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
            // Validasi visual saat pengguna mengetik
            validateField(input);
        }
        
        // Fungsi ini hanya membersihkan input agar selalu huruf dan spasi
        function validateLetterInput(input) {
            input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
            validateField(input);
        }

        // Fungsi terpusat untuk menampilkan atau menyembunyikan pesan error
        function validateField(input) {
            const errorId = input.id + 'Error';
            const errorElement = document.getElementById(errorId);

            if (!input.checkValidity() && input.value.length > 0) {
                input.classList.add('invalid-input');
                if (errorElement) errorElement.classList.remove('hidden');
            } else {
                input.classList.remove('invalid-input');
                if (errorElement) errorElement.classList.add('hidden');
            }
        }

        document.getElementById('memberForm').addEventListener('submit', function (e) {
            const inputs = this.querySelectorAll('input[required], select[required], textarea[required]');
            let isFormValid = true;

            inputs.forEach(input => {
                // Gunakan fungsi checkValidity() yang sudah mencakup minlength, maxlength, pattern, dll.
                if (!input.checkValidity()) {
                    isFormValid = false;
                    const errorId = input.id + 'Error';
                    const errorElement = document.getElementById(errorId);
                    input.classList.add('invalid-input');
                    
                    if (errorElement) {
                        // Tampilkan pesan error spesifik jika input tidak valid
                        errorElement.classList.remove('hidden');
                    }
                } else {
                     const errorId = input.id + 'Error';
                    const errorElement = document.getElementById(errorId);
                    input.classList.remove('invalid-input');
                    if (errorElement) {
                        errorElement.classList.add('hidden');
                    }
                }
            });

            if (!isFormValid) {
                e.preventDefault(); // Mencegah form dikirim jika tidak valid
                alert('Harap periksa kembali isian Anda. Pastikan semua kolom wajib diisi dengan benar.');
            }
        });
        
        // Menambahkan listener 'blur' untuk validasi saat pengguna meninggalkan field
        document.querySelectorAll('input[required], select[required], textarea[required]').forEach(input => {
            input.addEventListener('blur', () => validateField(input));
        });

    </script>
</body>
</html>