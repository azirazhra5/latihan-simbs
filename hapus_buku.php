<?php
require_once 'function.php';
require_login();

$id = intval($_GET['id'] ?? 0);
if (!$id) redirect("index.php");

if (hapus_buku($id)) {
    echo "<script>alert('Buku berhasil dihapus!'); window.location='index.php';</script>";
    exit;
} else {
    echo "<script>alert('Gagal menghapus buku!'); window.location='index.php';</script>";
    exit;
}
