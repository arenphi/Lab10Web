<?php

$sql = 'SELECT * FROM data_barang ORDER BY id_barang DESC';
$data_barang = $db->select($sql); 
?>

<h2>Daftar Barang</h2>
<div class="toolbar">
    <a class="btn" href="index.php?page=barang/add">Tambah Barang</a>
</div>
<div class="main">
    <table>
        <tr>
            <th>Gambar</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        
        <?php if($data_barang && count($data_barang) > 0): ?>
            <?php foreach($data_barang as $row): ?>
                <tr>
                    <td>
                        <?php if(!empty($row['gambar']) && file_exists($row['gambar'])): ?>
                            <img class="thumb" src="<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama']); ?>">
                        <?php else: ?>
                            <span class="noimg">-</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                    <td><?php echo number_format($row['harga_beli'],0,',','.'); ?></td>
                    <td><?php echo number_format($row['harga_jual'],0,',','.'); ?></td>
                    <td><?php echo (int)$row['stok']; ?></td>
                    <td>
                        <a class="link" href="index.php?page=barang/ubah&id=<?php echo $row['id_barang']; ?>">Ubah</a>
                        <a class="link del" href="index.php?page=barang/delete&id=<?php echo $row['id_barang']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Belum ada data</td>
            </tr>
        <?php endif; ?>
    </table>
</div>