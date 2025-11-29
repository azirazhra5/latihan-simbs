<?php
require_once 'function.php';
require_login();

$errors = [];
$kq = $koneksi->query("SELECT * FROM kategori ORDER BY nama_kategori");
$kategori_list = $kq->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = tambah_buku($_POST, $_FILES);
    if ($res === true) {
        echo "<script>alert('Buku berhasil ditambahkan!'); window.location='index.php';</script>";
        exit;
    } else {
        $errors[] = is_string($res) ? $res : "Gagal menambahkan buku!";
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Tambah Buku</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-4">
    <h1 class="mb-3">Tambah Buku</h1>
    <a href="index.php" class="mb-3 d-inline-block">Kembali</a>
    <div class="col-md-6">
        <?php foreach ($errors as $e): ?><div class="alert alert-danger"><?= h($e) ?></div><?php endforeach; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3"><label class="form-label fw-bold">Judul</label><input type="text" name="judul" class="form-control" required></div>
            <div class="mb-3"><label class="form-label fw-bold">Penulis</label><input type="text" name="penulis" class="form-control" required></div>
            <div class="mb-3"><label class="form-label fw-bold">Penerbit</label><input type="text" name="penerbit" class="form-control"></div>
            <div class="mb-3"><label class="form-label fw-bold">Kategori</label><select name="id_kategori" class="form-control"><?php foreach($kategori_list as $k){ echo "<option value=\"{$k['id_kategori']}\">".h($k['nama_kategori'])."</option>"; } ?></select></div>
            <div class="mb-3"><label class="form-label fw-bold">Gambar (jpg/png, max 2MB)</label><input type="file" name="gambar" class="form-control"></div>
            <div class="mb-3"><button type="submit" class="btn btn-primary btn-sm">Simpan</button></div>
        </form>
    </div>
</div>
</body>
</html>
