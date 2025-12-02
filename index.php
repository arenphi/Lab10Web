<?php
error_reporting(E_ALL); 
$base_path = dirname(__FILE__);

// Tentukan BASE URL secara dinamis untuk mengatasi masalah path CSS/Asset
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
// $_SERVER['PHP_SELF'] akan menghasilkan /lab10_php_oop/index.php
// Kita ambil nama folder root-nya (misal: /lab10_php_oop)
$folder_root = rtrim(dirname($_SERVER['PHP_SELF']), '/');
$base_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . $folder_root . '/';

// 1. Koneksi Database OOP & Membuat objek $db
require_once $base_path . '/config/database.php';
$db = new Database(); // Objek ini tersedia di semua file modul

// 2. Tentukan halaman yang akan dimuat (Routing)
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard'; 
$module_path = $base_path . '/modules/' . $page . '.php';

// 3. Load Header (Template)
// Variabel $base_url sekarang tersedia di header.php
require_once $base_path . '/views/header.php';

// 4. Load Konten Modul
if (file_exists($module_path)) {
    require_once $module_path;
} else {
    echo '<div class="container"><div class="main"><h2>404 Not Found</h2><p>Halaman yang Anda cari tidak ditemukan.</p></div></div>';
}

// 5. Load Footer (Template)
require_once $base_path . '/views/footer.php';
?>