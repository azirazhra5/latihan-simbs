<?php
require_once 'function.php';
$error = "";
$success = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hasil = register($_POST);
    if ($hasil === true) {
        $success = "Register berhasil! Silakan login.";
    } else {
        $error = $hasil;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Register Page</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container"><div class="row justify-content-center"><div class="col-md-4">
  <div class="login-card" style="margin-top:25%;padding:30px;border-radius:10px;background:white;">
    <h3 class="text-center mb-4">Register</h3>
    <?php if($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
    <?php if($success): ?><div class="alert alert-success"><?= h($success) ?></div><?php endif; ?>
    <form method="POST">
      <div class="mb-3"><label class="form-label fw-bold">Username</label><input type="text" name="username" class="form-control" required></div>
      <div class="mb-3"><label class="form-label fw-bold">Email</label><input type="email" name="email" class="form-control" required></div>
      <div class="mb-3"><label class="form-label fw-bold">Password</label><input type="password" name="password" class="form-control" required></div>
      <div class="mb-3"><label class="form-label fw-bold">Konfirmasi Password</label><input type="password" name="confirm_password" class="form-control" required></div>
      <button type="submit" class="btn btn-primary w-100">Register</button>
      <p class="mt-2">Sudah punya akun? <a href="login.php">Login</a></p>
    </form>
  </div>
</div></div></div>
</body>
</html>
