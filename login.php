<?php
session_start();
include 'config.php'; // File koneksi database

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM admin WHERE username='$username' LIMIT 1";
        $result = mysqli_query($conn, $query);
        $admin = mysqli_fetch_assoc($result);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Harap isi semua bidang!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Jumat Beramal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 350px;">
        <h3 class="text-center">Login Admin</h3>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            <a href="index.php">bukan admin?, klik disini untuk login</a>
        </form>
    </div>
</body>
</html>
