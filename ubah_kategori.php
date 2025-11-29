<?php
require_once "function.php";
require_login();

$id = $_GET['id'];
$q = $koneksi->query("SELECT * FROM kategori WHERE id_kategori = $id");
$kategori = $q->fetch_assoc();

if (isset($_POST["submit"])) {

    $_POST["id_kategori"] = $id;

    if (ubah_kategori($_POST)) {
        echo "<script>alert('Kategori diubah'); window.location='kategori.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal mengubah kategori');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ubah Kategori</title>
</head>
<body>

<h3>Ubah Kategori</h3>
<a href="kategori.php">Kembali</a>

<form method="POST">
    <label>Nama Kategori</label>
    <input type="text" name="nama_kategori" value="<?= $kategori['nama_kategori'] ?>" required>
    <br><br>
    <button type="submit" name="submit">Simpan</button>
</form>

</body>
</html>
