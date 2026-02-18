<?php
// This file should NOT be in production
// Use this locally only to generate password hashes
if ($_SERVER['HTTP_HOST'] !== 'localhost' && $_SERVER['HTTP_HOST'] !== '127.0.0.1') {
    die('This utility is only available locally.');
}

if (!isset($_POST['password'])) {
    ?>
    <form method="POST">
        <input type="password" name="password" placeholder="Enter password" required>
        <button type="submit">Hash Password</button>
    </form>
    <?php
    exit;
}

echo htmlspecialchars(password_hash($_POST['password'], PASSWORD_DEFAULT));
?>
