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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-blue-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-80 border border-gray-200">
        <h3 class="text-center text-lg font-semibold text-gray-700">Login Admin</h3>
        <?php if (isset($error)) echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mt-2'>$error</div>"; ?>
        <form action="" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="username" class="block text-gray-600">Username</label>
                <input type="text" name="username" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="mb-3">
                <label for="password" class="block text-gray-600">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <button type="submit" name="login" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Login</button>
            <p class="text-center text-sm text-gray-600 mt-3"><a href="dashboard_guest.php" class="text-blue-500 hover:underline">Bukan admin? Klik di sini untuk login</a></p>
        </form>
    </div>
</body>
</html>
