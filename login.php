<?php
session_start();
// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Sabar Menanti</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .form-input:focus {
            outline: 2px solid #1d4ed8;
        }
    </style>
</head>
<body style="background: url('assets/b.jpeg') no-repeat center center fixed; background-size: contain; background-color: #fff;" class="min-h-screen flex items-center justify-center">
    
    <div class="w-full max-w-md px-6">
        <div class="bg-white/80 backdrop-blur-sm rounded-lg shadow-md p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-semibold text-gray-700 mb-4">Login Admin</h1>

                <?php
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="mt-4 p-3 bg-red-100 text-red-700 rounded-lg">'.htmlspecialchars($_SESSION['error_message']).'</div>';
                    unset($_SESSION['error_message']);
                }
                ?>

                <div id="errorMessage" class="mt-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg hidden text-sm"></div>
            </div>

            <form id="loginForm" action="login_process.php" method="post" novalidate>
                <div class="mb-6">
                    <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                    <input type="text" id="username" name="username" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded form-input"
                           placeholder="Username">
                </div>

                <div class="mb-8">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 form-input focus:border-blue-500 focus:outline-none"
                               placeholder="Masukkan password">
                        <button type="button" id="togglePassword" 
                                class="absolute right-3 top-3 text-gray-500 hover:text-gray-700">
                            👁️
                        </button>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    Login
                </button>

                <div class="mt-4 text-center">
                    <a href="index.php" class="text-blue-600 hover:text-blue-800 underline text-sm">
                        ← Kembali ke Home
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
        });

        // Client-side Validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const errorElement = document.getElementById('errorMessage');
            
            errorElement.classList.add('hidden');
            
            if (!username || !password) {
                e.preventDefault();
                errorElement.textContent = 'Username dan password harus diisi!';
                errorElement.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>
