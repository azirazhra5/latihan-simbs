<?php
require_once 'function.php';
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    redirect("index.php");
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hasil = login_user($_POST);
    if ($hasil === true) {
        redirect("index.php");
    } else if ($hasil === "nouser") {
        $error = "Username / email tidak ditemukan!";
    } else if ($hasil === "wrongpass") {
        $error = "Password salah!";
    } else {
        $error = "Login gagal! Silakan coba lagi.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><title>Login - SIMBS</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
  <div class="row justify-content-center"><div class="col-md-4">
    <div class="login-card" style="margin-top:8%;padding:30px;border-radius:10px;background:white;">
      <h3 class="text-center mb-4" style="font-weight:700;font-size:28px;">SIMBS Login</h3>
      <?php if($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
      <form method="POST">
        <div class="mb-3"><label class="form-label fw-bold">Username / Email</label><input type="text" name="username" class="form-control" required></div>
        <div class="mb-3"><label class="form-label fw-bold">Password</label><input type="password" name="password" class="form-control" required></div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <p class="mt-3 text-center">Belum punya akun? <a href="register.php">Register</a></p>
      </form>
    </div>
  </div></div>
</div>
</body>
</html>
