<?php
$password = 'password123';  // Password yang akan di-hash

// Menghasilkan hash dari password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

echo "Password Hash: " . $hashedPassword;
?>
