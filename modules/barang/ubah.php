<?php
// Asumsi $db sudah tersedia dari index.php

function is_select($var, $val) {
    return ($var == $val) ? 'selected="selected"' : '';
}

// --- LOGIKA PENGAMBILAN DATA (GET) ---
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $sql = "SELECT * FROM data_barang WHERE id_barang = $id";
    // MENGGUNAKAN OOP: $db->get_row()
    $data = $db->get_row($sql);
    
    if (!$data) {
        header('Location: index.php?page=barang/list');
        exit;
    }
} else {
    header('Location: index.php?page=barang/list');
    exit;
}

// --- LOGIKA PEMROSESAN FORM (POST) ---
if (isset($_POST['submit'])) 
{
    $id_update = (int)$_POST['id_barang'];
    $gambar_lama = $_POST['gambar_lama'];
    
    $data_update = [
        'nama' => $_POST['nama'],
        'kategori' => $_POST['kategori'],
        'harga_jual' => (int)$_POST['harga_jual'],
        'harga_beli' => (int)$_POST['harga_beli'],
        'stok' => (int)$_POST['stok']
    ];
    $data_update['gambar'] = $gambar_lama;
    
    $file_gambar = $_FILES['file_gambar']; 
    
    // Proses upload gambar baru
    if ($file_gambar['error'] == 0 && !empty($file_gambar['name'])) 
    { 
        $filename = time() . '_' . str_replace(' ', '_', basename($file_gambar['name']));
        $target_dir = "gambar/";
        $destination = $target_dir . $filename;
        
        if(move_uploaded_file($file_gambar['tmp_name'], $destination)) 
        { 
            $data_update['gambar'] = $destination; 
            
            // Hapus gambar lama jika ada
            if (!empty($gambar_lama) && file_exists($gambar_lama)) {
                unlink($gambar_lama);
            }
        } 
    }
    
    $where = "id_barang = $id_update";
    
    // MENGGUNAKAN OOP: $db->update()
    $result = $db->update('data_barang', $data_update, $where);
    
    if ($result) {
        header('Location: index.php?page=barang/list');
        exit;
    } else {
        echo '<div class="main"><h2>Error</h2><p>Gagal mengubah data barang.</p></div>';
        exit;
    }
}
?>

<h2>Ubah Barang</h2>
<div class="main">
    <form method="post" action="index.php?page=barang/ubah&id=<?php echo htmlspecialchars($data['id_barang']); ?>" enctype="multipart/form-data"> 
        <input type="hidden" name="id_barang" value="<?php echo htmlspecialchars($data['id_barang']); ?>" />
        <input type="hidden" name="gambar_lama" value="<?php echo htmlspecialchars($data['gambar']); ?>" />

        <div class="input"><label>Nama Barang</label><input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required /></div> 
        <div class="input">
            <label>Kategori</label> 
            <select name="kategori"> 
                <option value="Komputer" <?php echo is_select($data['kategori'], 'Komputer'); ?>>Komputer</option> 
                <option value="Elektronik" <?php echo is_select($data['kategori'], 'Elektronik'); ?>>Elektronik</option> 
                <option value="Hand Phone" <?php echo is_select($data['kategori'], 'Hand Phone'); ?>>Hand Phone</option> 
            </select> 
        </div> 
        <div class="input"><label>Harga Jual</label><input type="number" name="harga_jual" value="<?php echo htmlspecialchars($data['harga_jual']); ?>" required /></div> 
        <div class="input"><label>Harga Beli</label><input type="number" name="harga_beli" value="<?php echo htmlspecialchars($data['harga_beli']); ?>" required /></div> 
        <div class="input"><label>Stok</label><input type="number" name="stok" value="<?php echo htmlspecialchars($data['stok']); ?>" required /></div> 
        
        <div class="input">
            <label>Gambar Saat Ini</label>
            <?php if (!empty($data['gambar'])): ?>
                <img src="<?php echo htmlspecialchars($data['gambar']); ?>" alt="Gambar Barang" class="thumb-preview">
            <?php else: ?>
                <p>Tidak ada gambar</p>
            <?php endif; ?>
            
            <label>File Gambar (Kosongkan jika tidak ingin mengubah)</label>
            <input type="file" name="file_gambar" accept="image/*" />
        </div>
        
        <div class="submit">
            <input type="submit" name="submit" value="Simpan Perubahan" class="btn" />
            <a class="btn btn-secondary" href="index.php?page=barang/list">Batal</a>
        </div>
    </form>
</div>