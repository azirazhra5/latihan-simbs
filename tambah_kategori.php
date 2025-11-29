<?php
require_once 'function.php';
require_login();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (tambah_kategori($_POST)) {
        echo "<script>alert('Kategori berhasil ditambahkan!'); window.location='kategori.php';</script>";
        exit;
    } else {
        $errors[] = "Gagal menambahkan kategori!";
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Tambah Kategori</title></head>
<body>
<div class="container mt-4">
    <h1 class="mb-2">Tambah Kategori</h1>
    <a href="kategori.php" class="mb-3 d-inline-block">Kembali</a>
    <?php foreach($errors as $e): ?><div class="alert alert-danger"><?= h($e) ?></div><?php endforeach; ?>
    <form method="POST">
        <div class="mb-3"><label class="form-label fw-bold">Nama Kategori</label><input type="text" name="nama_kategori" class="form-control" required></div>
        <div class="mb-3"><button type="submit" class="btn btn-primary btn-sm">Simpan</button></div>
    </form>
</div>
</body>
</html>
