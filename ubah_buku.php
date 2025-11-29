<?php 
session_start();
require_once 'function.php';
require_login();
// require_once 'koneksi.php';

$id = $_GET['id'];

$query = $koneksi->query("SELECT * FROM buku WHERE id_buku = '$id'");
$buku = $query->fetch_assoc();

// Ambil kategori
$kq = $koneksi->query("SELECT * FROM kategori ORDER BY nama_kategori");
$kategori = $kq->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['tombol_submit'])) {

    $judul     = $_POST['judul'];
    $penulis   = $_POST['penulis'];
    $penerbit  = $_POST['penerbit'];
    $id_kat    = $_POST['id_kategori'];

    $nama_gambar = $buku["gambar"];

    // Jika upload baru
    if ($_FILES['gambar']['error'] === 0) {

        // Hapus gambar lama
        if (!empty($nama_gambar) && file_exists("assets/uploads/$nama_gambar")) {
            unlink("assets/uploads/$nama_gambar");
        }

        $fileName = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];

        $nama_gambar = time() . "_" . $fileName;

        move_uploaded_file($tmp, "assets/uploads/" . $nama_gambar);
    }

    // UPDATE
    $update = $koneksi->query("UPDATE buku SET 
                judul = '$judul',
                penulis = '$penulis',
                penerbit = '$penerbit',
                gambar = '$nama_gambar',
                id_kategori = '$id_kat'
              WHERE id_buku = '$id'");

    if ($update) {
        echo "
            <script>
                alert('Buku berhasil diubah!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Buku gagal diubah!');
                document.location.href = 'index.php';
            </script>
        ";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ubah Buku</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>

<div class='container mt-4'>

    <h3>Ubah Buku</h3>
    <a href='index.php'>Kembali</a>

    <div class='col-md-6 mt-3'>
        
        <form method='POST' enctype='multipart/form-data'>

            <div class='mb-3'>
                <label class='fw-bold'>Judul</label>
                <input type='text' class='form-control'
                       name='judul' value='<?= $buku['judul'] ?>' required>
            </div>

            <div class='mb-3'>
                <label class='fw-bold'>Penulis</label>
                <input type='text' class='form-control'
                       name='penulis' value='<?= $buku['penulis'] ?>' required>
            </div>

            <div class='mb-3'>
                <label class='fw-bold'>Penerbit</label>
                <input type='text' class='form-control'
                       name='penerbit' value='<?= $buku['penerbit'] ?>'>
            </div>

            <div class='mb-3'>
                <label class='fw-bold'>Kategori</label>
                <select name='id_kategori' class='form-control'>
                    <?php foreach ($kategori as $k): ?>
                        <option value='<?= $k['id_kategori'] ?>'
                            <?= ($k['id_kategori'] == $buku['id_kategori']) ? 'selected' : '' ?>>
                            <?= $k['nama_kategori'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class='mb-3'>
                <label class='fw-bold'>Gambar</label>
                <input type='file' name='gambar' class='form-control'>
                <small>Gambar sekarang: <?= $buku['gambar'] ?></small>
            </div>

            <button type='submit' name='tombol_submit' class='btn btn-primary btn-sm'>Simpan</button>

        </form>

    </div>

</div>

</body>
</html>
