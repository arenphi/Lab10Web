<?php 
// Asumsi $db sudah tersedia dari index.php

if (isset($_POST['submit'])) 
{ 
    $data = [
        'nama' => $_POST['nama'],
        'kategori' => $_POST['kategori'],
        'harga_jual' => (int)$_POST['harga_jual'],
        'harga_beli' => (int)$_POST['harga_beli'],
        'stok' => (int)$_POST['stok'],
        'gambar' => null 
    ];
    
    $file_gambar = $_FILES['file_gambar']; 
    
    // Proses upload gambar
    if ($file_gambar['error'] == 0 && !empty($file_gambar['name'])) 
    { 
        // Tambahkan timestamp agar nama file unik
        $filename = time() . '_' . str_replace(' ', '_', basename($file_gambar['name']));
        $target_dir = "gambar/"; // Path relatif dari index.php
        $destination = $target_dir . $filename;
        
        if(move_uploaded_file($file_gambar['tmp_name'], $destination)) 
        { 
            $data['gambar'] = $destination; 
        } 
    } 
    
    // MENGGUNAKAN OOP: $db->insert()
    $result = $db->insert('data_barang', $data);
    
    if ($result) {
        header('Location: index.php?page=barang/list');
        exit;
    } else {
        // Gagal insert
        echo '<div class="main"><h2>Error</h2><p>Gagal menyimpan data barang. Pastikan kolom di database sudah benar.</p></div>';
        exit;
    }
} 
?>
<h2>Tambah Barang Baru</h2> 
<div class="main"> 
    <form method="post" action="index.php?page=barang/add" enctype="multipart/form-data"> 
        <div class="input"><label>Nama Barang</label><input type="text" name="nama" required /></div> 
        <div class="input">
            <label>Kategori</label>
            <select name="kategori">
                <option value="Komputer">Komputer</option>
                <option value="Elektronik">Elektronik</option>
                <option value="Hand Phone">Hand Phone</option>
            </select>
        </div> 
        <div class="input"><label>Harga Jual</label><input type="number" name="harga_jual" required /></div> 
        <div class="input"><label>Harga Beli</label><input type="number" name="harga_beli" required /></div> 
        <div class="input"><label>Stok</label><input type="number" name="stok" required /></div> 
        <div class="input"><label>File Gambar</label><input type="file" name="file_gambar" accept="image/*" /></div>
        <div class="submit"><input type="submit" name="submit" value="Simpan" class="btn" /></div> 
    </form>
</div>