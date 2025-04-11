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
    mysqli_query($conn, "DELETE FROM kelas WHERE id = $id");
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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<!-- Konten -->
<div class="container mx-auto mt-6 p-4 bg-white shadow-lg rounded-lg">
    <h3 class="text-center text-xl font-semibold text-gray-700 flex items-center justify-center gap-2">
        <i data-lucide="graduation-cap" class="w-5 h-5 text-blue-600"></i>
        Kelola Kelas
    </h3>

    <form action="" method="POST" class="mt-4">
        <label for="nama_kelas" class="block font-medium text-gray-700">Nama Kelas:</label>
        <input type="text" id="nama_kelas" name="nama_kelas" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" required>
        
        <div class="mt-3 flex space-x-2">
            <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 flex items-center gap-1">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                Tambahkan
            </button>
            <a href="dashboard.php" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 flex items-center gap-1">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali
            </a>
        </div>
    </form>

    <hr class="my-4">

    <!-- Tabel -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-blue-200 text-gray-800">
                <tr>
                    <th class="border border-gray-300 p-2">No</th>
                    <th class="border border-gray-300 p-2">Nama Kelas</th>
                    <th class="border border-gray-300 p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($kelas)) { ?>
                <tr class="bg-white">
                    <td class="border border-gray-300 p-2 text-center"><?php echo $no++; ?></td>
                    <td class="border border-gray-300 p-2"><?php echo $row['nama_kelas']; ?></td>
                    <td class="border border-gray-300 p-2 text-center space-x-1">
                        <button 
                        class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-md inline-flex items-center justify-center" 
                        onclick="editKelas(<?php echo $row['id']; ?>, '<?php echo $row['nama_kelas']; ?>')">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                            Edit
                        </button>
                        <a href="tambah_kelas.php?tanggal=<?php echo $row['id']; ?>" 
       class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-md inline-flex items-center justify-center" 
       title="Hapus" 
       onclick="return confirm('Hapus data ini?');">
        <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
    </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            document.getElementById('menu').classList.toggle('hidden');
        });

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
    <!-- Lucide Icon Script -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

</body>
</html>
