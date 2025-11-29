<?php
require_once 'function.php';
require_login();

$id = intval($_GET['id'] ?? 0);
if (!$id) redirect("kategori.php");

if (hapus_kategori($id)) {
    echo "<script>alert('Kategori berhasil dihapus!'); window.location='kategori.php';</script>";
    exit;
} else {
    echo "<script>alert('Gagal menghapus kategori!'); window.location='kategori.php';</script>";
    exit;
}
