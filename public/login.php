<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nice Coffee POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-red-600 to-red-900">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-2xl p-8">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-red-600">☕ Nice Coffee</h1>
                <p class="text-gray-600 mt-2">POS System</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="../api/login.php">
                <!-- Username -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Username</label>
                    <input 
                        type="text" 
                        name="username" 
                        placeholder="Masukkan username"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-500"
                        required
                    >
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Masukkan password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-500"
                        required
                    >
                </div>

                <!-- Error Message -->
                <?php if(isset($_GET['error'])): ?>
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
                <?php endif; ?>

                <!-- Success Message -->
                <?php if(isset($_GET['success'])): ?>
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
                <?php endif; ?>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded-lg transition duration-200"
                >
                    Login
                </button>

                <!-- Demo Credentials -->
                <div class="mt-6 p-4 bg-gray-100 rounded-lg text-sm text-gray-600">
                    <p class="font-semibold mb-2">📝 Demo Credentials:</p>
                    <p>Username: <span class="font-mono bg-gray-200 px-2 py-1">admin</span></p>
                    <p>Password: <span class="font-mono bg-gray-200 px-2 py-1">admin123</span></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
