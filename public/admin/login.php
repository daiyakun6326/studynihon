<?php
// filepath: c:\xampp\htdocs\StudyNihon\public\admin\login.php

require_once __DIR__ . '/auth.php';

if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: admin.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (
        hash_equals(ADMIN_USERNAME, $username) &&
        password_verify($password, ADMIN_PASSWORD_HASH)
    ) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;

        header('Location: admin.php');
        exit;
    }

    $error = 'username atau password salah.';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>login</title>
</head>
<body>
  <h1>login</h1>

  <?php if ($error !== ''): ?>
    <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
  <?php endif; ?>

  <form method="post">
    <label>
      username
      <input type="text" name="username" required autocomplete="username">
    </label>
    <br>
    <label>
      password
      <input type="password" name="password" required autocomplete="current-password">
    </label>
    <br>
    <button type="submit">login</button>
  </form>
</body>
</html>