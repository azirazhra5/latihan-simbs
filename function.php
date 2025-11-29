<?php
// function.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// include koneksi
require_once __DIR__ . '/koneksi.php';

/* HELPERS */
function h($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
function redirect($url){ header("Location: $url"); exit; }
function require_login(){
    if (!isset($_SESSION['user_id'])) redirect("login.php");
}
function current_user_name(){ return $_SESSION['nama'] ?? "Guest"; }

/* AUTH */
function register($data){
    global $koneksi;
    $username = trim($data['username']);
    $email = trim($data['email']);
    $password = trim($data['password']);
    $confirm = trim($data['confirm_password']);

    if ($password !== $confirm) return "Password dan konfirmasi tidak sama!";

    $stmt = $koneksi->prepare("SELECT id FROM user WHERE username=? OR email=? LIMIT 1");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) return "Username atau email sudah digunakan!";

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $ins = $koneksi->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
    $ins->bind_param("sss", $username, $email, $hash);
    if ($ins->execute()) return true;
    return "Gagal register: " . $koneksi->error;
}

function login_user($data){
    global $koneksi;
    $userOrEmail = trim($data['username']);
    $password = trim($data['password']);

    $stmt = $koneksi->prepare("SELECT id, username, password FROM user WHERE username=? OR email=? LIMIT 1");
    $stmt->bind_param("ss", $userOrEmail, $userOrEmail);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) return "nouser";
    $row = $res->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['nama'] = $row['username'];
        $_SESSION['login'] = true;
        return true;
    }
    return "wrongpass";
}

function logout_user(){
    $_SESSION = [];
    session_unset();
    session_destroy();
    redirect("login.php");
}

/* KATEGORI CRUD */
function tambah_kategori($data){
    global $koneksi;
    $nama = trim($data['nama_kategori']);
    $stmt = $koneksi->prepare("INSERT INTO kategori (nama_kategori, tanggal_input) VALUES (?, NOW())");
    $stmt->bind_param("s", $nama);
    return $stmt->execute();
}

function ubah_kategori($data){
    global $koneksi;
    $id = intval($data['id_kategori']);
    $nama = trim($data['nama_kategori']);
    $stmt = $koneksi->prepare("UPDATE kategori SET nama_kategori=?, tanggal_input=NOW() WHERE id_kategori=?");
    $stmt->bind_param("si", $nama, $id);
    return $stmt->execute();
}

function hapus_kategori($id){
    global $koneksi;
    $id = intval($id);
    $stmt = $koneksi->prepare("DELETE FROM kategori WHERE id_kategori=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

/* BUKU CRUD */
function tambah_buku($data, $file){
    global $koneksi;
    $judul = trim($data['judul']);
    $penulis = trim($data['penulis']);
    $penerbit = trim($data['penerbit']);
    $idkategori = intval($data['id_kategori']);

    $namaFile = null;
    if (!empty($file['gambar']['name']) && $file['gambar']['error'] === 0) {
        $ext = strtolower(pathinfo($file['gambar']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];
        if (!in_array($ext, $allowed)) return "Ekstensi gambar tidak diperbolehkan";
        if ($file['gambar']['size'] > 2 * 1024 * 1024) return "Ukuran gambar maksimal 2MB";

        $upload_dir = __DIR__ . '/uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        $namaFile = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/','', $file['gambar']['name']);
        move_uploaded_file($file['gambar']['tmp_name'], $upload_dir . $namaFile);
    }

    $stmt = $koneksi->prepare("INSERT INTO buku (judul, penulis, penerbit, gambar, id_kategori, tanggal_input) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssi", $judul, $penulis, $penerbit, $namaFile, $idkategori);
    return $stmt->execute();
}

function ubah_buku($data, $file){
    global $koneksi;
    $id = intval($data['id_buku']);
    $judul = trim($data['judul']);
    $penulis = trim($data['penulis']);
    $penerbit = trim($data['penerbit']);
    $idkategori = intval($data['id_kategori']);

    // ambil gambar lama
    $g = $koneksi->prepare("SELECT gambar FROM buku WHERE id_buku=?");
    $g->bind_param("i", $id);
    $g->execute();
    $old = $g->get_result()->fetch_assoc();
    $oldname = $old['gambar'] ?? null;
    $namaFile = $oldname;

    if (!empty($file['gambar']['name']) && $file['gambar']['error'] === 0) {
        $ext = strtolower(pathinfo($file['gambar']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];
        if (!in_array($ext, $allowed)) return "Ekstensi gambar tidak diperbolehkan";
        if ($file['gambar']['size'] > 2 * 1024 * 1024) return "Ukuran gambar maksimal 2MB";

        $upload_dir = __DIR__ . '/uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        $namaFile = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/','', $file['gambar']['name']);
        move_uploaded_file($file['gambar']['tmp_name'], $upload_dir . $namaFile);

        if (!empty($oldname) && file_exists($upload_dir . $oldname)) @unlink($upload_dir . $oldname);
    }

    $stmt = $koneksi->prepare("UPDATE buku SET judul=?, penulis=?, penerbit=?, gambar=?, id_kategori=? WHERE id_buku=?");
    $stmt->bind_param("ssssii", $judul, $penulis, $penerbit, $namaFile, $idkategori, $id);
    return $stmt->execute();
}

function hapus_buku($id){
    global $koneksi;
    $id = intval($id);
    $g = $koneksi->prepare("SELECT gambar FROM buku WHERE id_buku=?");
    $g->bind_param("i", $id);
    $g->execute();
    $r = $g->get_result()->fetch_assoc();
    $old = $r['gambar'] ?? null;
    $upload_dir = __DIR__ . '/uploads/';
    if (!empty($old) && file_exists($upload_dir . $old)) @unlink($upload_dir . $old);

    $stmt = $koneksi->prepare("DELETE FROM buku WHERE id_buku=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
