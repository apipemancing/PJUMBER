<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

// Tambah Kelas
if (isset($_POST['submit'])) {
    $nama_kelas = mysqli_real_escape_string($conn, $_POST['nama_kelas']);

    $cekKelas = mysqli_query($conn, "SELECT * FROM kelas WHERE nama_kelas = '$nama_kelas'");
    if (mysqli_num_rows($cekKelas) > 0) {
        echo "<script>alert('Kelas sudah ada!'); window.location.href='kelas.php';</script>";
        exit();
    }

    $query = "INSERT INTO kelas (nama_kelas) VALUES ('$nama_kelas')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Kelas berhasil ditambahkan!'); window.location.href='tambah_kelas.php';</script>";
    } else {
        echo "Gagal menambahkan kelas: " . mysqli_error($conn);
    }
}

// Hapus Kelas
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM Kelas WHERE id = $id");
    header("Location: tambah_kelas.php");
    exit();
}

// Edit Kelas
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $nama_kelas = mysqli_real_escape_string($conn, $_POST['nama_kelas']);
    
    mysqli_query($conn, "UPDATE kelas SET nama_kelas = '$nama_kelas' WHERE id = $id");
    echo "<script>alert('Kelas berhasil diperbarui!'); window.location.href='tambah_kelas.php';</script>";
}

// Ambil daftar kelas
$kelas = mysqli_query($conn, "SELECT * FROM kelas ORDER BY nama_kelas ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h3>Kelola Kelas</h3>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nama_kelas" class="form-label">Nama Kelas:</label>
                <input type="text" id="nama_kelas" name="nama_kelas" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Tambahkan</button>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($kelas)) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['nama_kelas']; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editKelas(<?php echo $row['id']; ?>, '<?php echo $row['nama_kelas']; ?>')">Edit</button>
                        <a href="tambah_kelas.php?hapus=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kelas ini?');">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        function editKelas(id, nama) {
            let newNama = prompt("Edit Nama Kelas:", nama);
            if (newNama !== null && newNama.trim() !== "") {
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "tambah_kelas.php";
                
                let inputId = document.createElement("input");
                inputId.type = "hidden";
                inputId.name = "id";
                inputId.value = id;
                form.appendChild(inputId);
                
                let inputNama = document.createElement("input");
                inputNama.type = "hidden";
                inputNama.name = "nama_kelas";
                inputNama.value = newNama;
                form.appendChild(inputNama);
                
                let inputSubmit = document.createElement("input");
                inputSubmit.type = "hidden";
                inputSubmit.name = "update";
                inputSubmit.value = "1";
                form.appendChild(inputSubmit);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
