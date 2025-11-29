<?php
// koneksi.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "latihan_simbs";

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
$koneksi->set_charset("utf8mb4");
