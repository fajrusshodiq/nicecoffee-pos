<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php?error=Silakan login terlebih dahulu');
    exit;
}

// Include config
require_once __DIR__ . '/../config/config.php';

$user_name = $_SESSION['full_name'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Nice Coffee POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Container -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar - Hidden on mobile, visible on desktop -->
        <div class="hidden md:block w-64 bg-red-700 text-white shadow-lg overflow-y-auto">
            <div class="p-6 border-b border-red-600">
                <h1 class="text-2xl font-bold">☕ Nice Coffee</h1>
                <p class="text-red-200 text-sm">POS System</p>
            </div>

            <nav class="p-4">
                <a href="dashboard.php" class="block px-4 py-2 rounded-lg bg-red-600 text-white mb-2 hover:bg-red-800 transition">
                    📊 Dashboard
                </a>
                <a href="pos.php" class="block px-4 py-2 rounded-lg hover:bg-red-600 transition mb-2">
                    🛒 Point of Sale
                </a>
                <a href="products.php" class="block px-4 py-2 rounded-lg hover:bg-red-600 transition mb-2">
                    📦 Produk
                </a>
                <a href="categories.php" class="block px-4 py-2 rounded-lg hover:bg-red-600 transition mb-2">
                    🏷️ Kategori
                </a>
                <a href="customers.php" class="block px-4 py-2 rounded-lg hover:bg-red-600 transition mb-2">
                    👥 Pelanggan
                </a>
                <a href="reports.php" class="block px-4 py-2 rounded-lg hover:bg-red-600 transition mb-2">
                    📈 Laporan
                </a>
                <a href="users.php" class="block px-4 py-2 rounded-lg hover:bg-red-600 transition mb-2">
                    👤 Pengguna
                </a>
                <hr class="my-4 border-red-600">
                <a href="../api/logout.php" class="block px-4 py-2 rounded-lg hover:bg-red-600 transition text-red-100">
                    🚪 Logout
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">Dashboard</h2>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-gray-800 font-semibold text-sm md:text-base"><?php echo htmlspecialchars($user_name); ?></p>
                        <p class="text-gray-500 text-xs md:text-sm"><?php echo ucfirst($role); ?></p>
                    </div>
                    <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white font-bold">
                        <?php echo strtoupper(substr($user_name, 0, 1)); ?>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="flex-1 p-4 md:p-6 overflow-y-auto">
                <!-- Welcome Section -->
                <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-2xl font-bold mb-2">Selamat Datang, <?php echo htmlspecialchars($user_name); ?>! 👋</h3>
                    <p class="text-red-100">Kelola outlet coffee Anda dengan mudah dan profesional</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6 hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-xs md:text-sm">Total Penjualan Hari Ini</p>
                                <p class="text-lg md:text-2xl font-bold text-gray-800">Rp 2.450.000</p>
                            </div>
                            <div class="text-3xl md:text-4xl text-red-600">💰</div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6 hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-xs md:text-sm">Total Transaksi</p>
                                <p class="text-lg md:text-2xl font-bold text-gray-800">45</p>
                            </div>
                            <div class="text-3xl md:text-4xl text-blue-600">📊</div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6 hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-xs md:text-sm">Produk Terjual</p>
                                <p class="text-lg md:text-2xl font-bold text-gray-800">123</p>
                            </div>
                            <div class="text-3xl md:text-4xl text-green-600">📦</div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6 hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-xs md:text-sm">Stok Rendah</p>
                                <p class="text-lg md:text-2xl font-bold text-gray-800">3</p>
                            </div>
                            <div class="text-3xl md:text-4xl text-yellow-600">⚠️</div>
                        </div>
                    </div>
                </div>

                <!-- Charts & Tables -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Sales Chart -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6">
                        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-4">📈 Penjualan 7 Hari Terakhir</h3>
                        <div class="h-48 md:h-64 flex items-end justify-between gap-2">
                            <div class="flex-1 h-24 bg-red-200 rounded hover:bg-red-300 transition"></div>
                            <div class="flex-1 h-32 bg-red-300 rounded hover:bg-red-400 transition"></div>
                            <div class="flex-1 h-40 bg-red-400 rounded hover:bg-red-500 transition"></div>
                            <div class="flex-1 h-28 bg-red-300 rounded hover:bg-red-400 transition"></div>
                            <div class="flex-1 h-36 bg-red-400 rounded hover:bg-red-500 transition"></div>
                            <div class="flex-1 h-44 bg-red-500 rounded hover:bg-red-600 transition"></div>
                            <div class="flex-1 h-32 bg-red-400 rounded hover:bg-red-500 transition"></div>
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6">
                        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-4">🛒 Transaksi Terbaru</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs md:text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-2 md:px-4 py-2 text-left">No Order</th>
                                        <th class="px-2 md:px-4 py-2 text-left">Total</th>
                                        <th class="px-2 md:px-4 py-2 text-left">Jam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-2 md:px-4 py-2">#ORD-001</td>
                                        <td class="px-2 md:px-4 py-2">Rp 125.000</td>
                                        <td class="px-2 md:px-4 py-2">09:15</td>
                                    </tr>
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-2 md:px-4 py-2">#ORD-002</td>
                                        <td class="px-2 md:px-4 py-2">Rp 250.000</td>
                                        <td class="px-2 md:px-4 py-2">09:45</td>
                                    </tr>
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-2 md:px-4 py-2">#ORD-003</td>
                                        <td class="px-2 md:px-4 py-2">Rp 175.000</td>
                                        <td class="px-2 md:px-4 py-2">10:20</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
