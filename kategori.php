<?php
require_once 'function.php';
require_login();
$nama_user = current_user_name();
$query = "SELECT * FROM kategori ORDER BY id_kategori DESC";
$result = $koneksi->query($query);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SIMBS | Data Kategori</title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">
    <!-- NAVBAR/SIDEBAR same as index (omitted here for brevity) -->
    <!-- Reuse sidebar/navbar from index or include a shared file -->
    <main class="app-main">
        <div class="app-content-header"><div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Data Kategori</h3>
                    <a href="tambah_kategori.php"><button class="btn btn-primary btn-sm">Tambah Data</button></a>
                </div>
                <div class="col-sm-6 d-flex flex-column align-items-end">
                    <ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php">Home</a></li><li class="breadcrumb-item active">Data Kategori</li></ol>
                </div>
            </div>
        </div></div>

        <div class="app-content"><div class="container-fluid">
            <table class="table table-striped table-hover">
                <tr><th>No</th><th>ID Kategori</th><th>Nama Kategori</th><th>Tanggal Input</th><th>Aksi</th></tr>
                <?php $no=1; while($d = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $d['id_kategori']; ?></td>
                    <td><?= h($d['nama_kategori']); ?></td>
                    <td><?= $d['tanggal_input']; ?></td>
                    <td>
                        <a href="ubah_kategori.php?id=<?= $d['id_kategori']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus_kategori.php?id=<?= $d['id_kategori']; ?>" onclick="return confirm('Hapus kategori?')" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div></div>

    </main>
</div>
<script src="dist/js/adminlte.js"></script>
</body>
</html>
