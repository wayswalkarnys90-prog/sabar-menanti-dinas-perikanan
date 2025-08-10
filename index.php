<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Beranda - SABAR MENANTI</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cover bg-center min-h-screen flex items-center justify-center" style="background-image: url('assets/pantai.jpg');">
  <div class="bg-white/80 backdrop-blur-md p-8 rounded-2xl shadow-lg text-center w-[90%] max-w-xl">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">SABAR MENANTI</h1>
    <p class="text-gray-600 mb-6 text-lg">DATA DINAS PERIKANAN</p>
    
    <div class="flex justify-center gap-6">
      <a href="cek_data.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg text-lg shadow transition duration-300">
        Cek Data
      </a>
      <a href="login.php" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg text-lg shadow transition duration-300">
        Login Admin
      </a>
    </div>
    
    <footer class="mt-8 text-sm text-gray-500">
      &copy; <?= date('Y') ?> Sabar Menanti. All rights reserved.
    </footer>
  </div>
</body>
</html>
