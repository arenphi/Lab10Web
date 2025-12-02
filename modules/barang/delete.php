<?php 
// Asumsi $db sudah tersedia dari index.php

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // 1. Ambil data path gambar lama sebelum dihapus
    $sql_gambar = "SELECT gambar FROM data_barang WHERE id_barang = $id";
    $data = $db->get_row($sql_gambar);

    // 2. Hapus data dari database
    $where = "id_barang = $id";
    // MENGGUNAKAN OOP: $db->delete()
    $result = $db->delete('data_barang', $where);
    
    // 3. Hapus file gambar jika data berhasil dihapus
    if ($result && $data && !empty($data['gambar']) && file_exists($data['gambar'])) {
        unlink($data['gambar']);
    }
}

// Redirect kembali ke halaman list
header('Location: index.php?page=barang/list'); 
exit;
?>