<?php
require_once 'function.php';
require_login();

$nama_user = current_user_name();

$query = "SELECT b.*, k.nama_kategori FROM buku b LEFT JOIN kategori k ON b.id_kategori=k.id_kategori ORDER BY b.id_buku DESC";
$result = $koneksi->query($query);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SIMBS | Data Buku</title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">
    <!-- NAVBAR -->
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" data-lte-toggle="sidebar"><i class="bi bi-list"></i></a></li>
                <li class="nav-item d-none d-md-block"><a href="index.php" class="nav-link">Data Buku</a></li>
                <li class="nav-item d-none d-md-block"><a href="kategori.php" class="nav-link">Data Kategori</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><span class="nav-link"><?= h($nama_user) ?></span></li>
            </ul>
        </div>
    </nav>

    <!-- SIDEBAR -->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
            <a href="index.php" class="brand-link">
                <img src="dist/assets/img/AdminLTELogo.png" class="brand-image opacity-75 shadow">
                <span class="brand-text fw-light">SIMBS</span>
            </a>
        </div>
        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu" data-lte-toggle="treeview">
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-speedometer"></i>
                            <p>Dashboard <i class="nav-arrow bi bi-chevron-right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"><a href="index.php" class="nav-link active"><i class="bi bi-circle nav-icon"></i><p>Data Buku</p></a></li>
                            <li class="nav-item"><a href="kategori.php" class="nav-link"><i class="bi bi-circle nav-icon"></i><p>Data Kategori</p></a></li>
                        </ul>
                    </li>
                    <li class="nav-header">AUTENTIKASI</li>
                    <li class="nav-item"><a href="logout.php" class="nav-link"><i class="bi bi-box-arrow-right nav-icon"></i><p>Log Out</p></a></li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="app-main">
        <div class="app-content-header"><div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Data Buku</h3>
                    <a href="tambah_buku.php"><button class="btn btn-primary btn-sm">Tambah Data</button></a>
                </div>
                <div class="col-sm-6 d-flex flex-column align-items-end">
                    <ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php">Home</a></li><li class="breadcrumb-item active">Data Buku</li></ol>
                </div>
            </div>
        </div></div>

        <div class="app-content"><div class="container-fluid">
            <table class="table table-striped table-hover">
                <tr>
                    <th>No</th><th>ID Buku</th><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Gambar</th><th>Kategori</th><th>Tanggal Input</th><th>Aksi</th>
                </tr>
                <?php $no=1; while($d = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $d['id_buku']; ?></td>
                    <td><?= h($d['judul']); ?></td>
                    <td><?= h($d['penulis']); ?></td>
                    <td><?= h($d['penerbit']); ?></td>
                    <td><?php if (!empty($d['gambar'])): ?><img src="uploads/<?= h($d['gambar']); ?>" width="60"><?php endif; ?></td>
                    <td><?= h($d['nama_kategori'] ?? ''); ?></td>
                    <td><?= $d['tanggal_input']; ?></td>
                    <td>
                        <a href="ubah_buku.php?id=<?= $d['id_buku']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus_buku.php?id=<?= $d['id_buku']; ?>" onclick="return confirm('Hapus?')" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div></div>
    </main>

    <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">SIMBS System</div>
        <strong>Copyright © 2025</strong>
    </footer>
</div>
<script src="dist/js/adminlte.js"></script>
</body>
</html>
