<?php
session_start();
if (!isset($_SESSION['admin']) || !isset($_SESSION['tanggal'])) {
    header("Location: tambah_data_admin1.php");
    exit();
}
include 'config.php';

$tanggal = $_SESSION['tanggal'];
$totalSumbangan = 0;

if (isset($_POST['simpan'])) {
    if (!empty($_POST['data_json'])) {
        $data_array = json_decode($_POST['data_json'], true);

        if ($data_array) {
            foreach ($data_array as $item) {
                $kelas = mysqli_real_escape_string($conn, $item['kelas']);
                $jumlah = (int) $item['jumlah'];
                $anonim = isset($item['anonim']) && $item['anonim'] == true ? 1 : 0;
                
                $query = "INSERT INTO jumat_beramal (tanggal, kelas, jumlah, anonim) VALUES ('$tanggal', '$kelas', '$jumlah', '$anonim')";
                $result = mysqli_query($conn, $query);
                
                if (!$result) {
                    die("Error: " . mysqli_error($conn));
                }

                $totalSumbangan += $jumlah;
            }
        }
    }

    if ($totalSumbangan > 0) {
        $queryUpdateSaldo = "UPDATE saldo_total SET saldo = saldo + $totalSumbangan WHERE id = 1";
        mysqli_query($conn, $queryUpdateSaldo);
    }

    echo "<script>alert('Data berhasil ditambahkan!'); window.location.href = 'dashboard.php';</script>";
}

// Ambil semua kelas dari database
$kelasSemua = [];
$result = mysqli_query($conn, "SELECT nama_kelas FROM kelas");
while ($row = mysqli_fetch_assoc($result)) {
    $kelasSemua[] = $row['nama_kelas'];
}

// Ambil kelas yang memiliki sumbangan
$kelasMenyumbang = [];
$data = mysqli_query($conn, "SELECT kelas, jumlah FROM jumat_beramal WHERE tanggal='$tanggal'");
while ($row = mysqli_fetch_assoc($data)) {
    if ($row['jumlah'] == 0) {
        $kelasTidakBerpartisipasi[] = $row['kelas'];
    } else {
        $kelasMenyumbang[] = $row['kelas'];
    }
}

// Kelas yang tidak berpartisipasi HANYA yang memiliki jumlah sumbangan 0
$kelasTidakBerpartisipasi = array_diff($kelasSemua, $kelasMenyumbang);

$result = mysqli_query($conn, "SELECT nama_kelas FROM kelas");
$kelas_list = [];
while ($row = mysqli_fetch_assoc($result)) {
    $kelas_list[] = $row['nama_kelas'];
}

$data = mysqli_query($conn, "SELECT * FROM jumat_beramal WHERE tanggal='$tanggal'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data - Jumat Beramal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .scrollable-table {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let kelasList = <?php echo json_encode($kelas_list); ?>;
            let dataSumbangan = [];

            function updateTable() {
                let table = document.getElementById("kelasTable");
                table.innerHTML = "";
                dataSumbangan.forEach((item, index) => {
                    let row = table.insertRow();
                    row.innerHTML = `
                        <td>${item.kelas}</td>
                        <td>Rp ${parseInt(item.jumlah).toLocaleString('id-ID')}</td>
                        <td>${item.anonim ? 'Ya' : 'Tidak'}</td>
                        <td><button class="bg-red-500 text-white px-2 py-1 rounded" onclick="hapusKelas(${index})">Hapus</button></td>
                    `;
                });
                updateDatalist();
            }

            function updateDatalist() {
                let datalist = document.getElementById("kelasList");
                datalist.innerHTML = "";
                kelasList.forEach(kelas => {
                    if (!dataSumbangan.some(item => item.kelas === kelas)) {
                        let option = document.createElement("option");
                        option.value = kelas;
                        datalist.appendChild(option);
                    }
                });
            }

            window.hapusKelas = function(index) {
                dataSumbangan.splice(index, 1);
                updateTable();
            };

            document.getElementById("tambahKelas").addEventListener("click", function(event) {
                event.preventDefault();
                let kelas = document.getElementById("kelasInput").value.trim();
                let jumlah = document.getElementById("jumlahInput").value;
                let anonim = document.getElementById("anonimInput").checked;

                if (kelas && jumlah && !dataSumbangan.some(item => item.kelas === kelas)) {
                    dataSumbangan.push({ kelas, jumlah, anonim });
                    updateTable();
                    document.getElementById("kelasInput").value = "";
                    document.getElementById("jumlahInput").value = "";
                    document.getElementById("anonimInput").checked = false;
                }
            });

            document.getElementById("dataForm").addEventListener("submit", function() {
                document.getElementById("data_json").value = JSON.stringify(dataSumbangan);
            });

            updateDatalist();
        });
    </script>
</head>
</head>
<body class="bg-gray-100 p-4 font-sans">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
        <h3 class="text-center text-2xl font-bold text-blue-600 flex items-center justify-center gap-2">
            <i data-lucide="plus-circle" class="w-6 h-6 text-blue-600"></i>
            Tambah Data - <?php echo $tanggal; ?>
        </h3>

        <!-- Form Tambah -->
        <form action="" method="POST" class="flex gap-2 mt-6 items-center">
            <div class="flex items-center gap-1 w-1/3">
                <i data-lucide="users" class="w-4 h-4 text-gray-600"></i>
                <input type="text" id="kelasInput" class="border border-gray-300 p-2 w-full rounded" list="kelasList" placeholder="Nama Kelas" required>
                <datalist id="kelasList"></datalist>
            </div>
            <div class="flex items-center gap-1 w-1/3">
                <i data-lucide="coins" class="w-4 h-4 text-gray-600"></i>
                <input type="number" id="jumlahInput" class="border border-gray-300 p-2 w-full rounded" placeholder="Jumlah Sumbangan" required>
            </div>
            <label class="flex items-center gap-1 text-sm text-gray-700">
                <input type="checkbox" id="anonimInput" class="accent-blue-500"> Anonim
            </label>
            <button id="tambahKelas" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded flex items-center gap-1">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah
            </button>
        </form>

        <!-- Tabel Data Kelas -->
        <h4 class="mt-6 text-lg font-semibold text-gray-700 flex items-center gap-2">
            <i data-lucide="table" class="w-5 h-5 text-gray-500"></i> Data Kelas yang Ditambahkan:
        </h4>
        <div class="scrollable-table border border-gray-300 rounded p-2 mt-2 bg-gray-50">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="p-2 border">Kelas</th>
                        <th class="p-2 border">Jumlah</th>
                        <th class="p-2 border">Anonim</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="kelasTable" class="text-center text-gray-700"></tbody>
            </table>
        </div>

        <!-- Tombol Simpan -->
        <form id="dataForm" action="" method="POST" class="mt-6">
            <input type="hidden" name="data_json" id="data_json">
            <button type="submit" name="simpan" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded w-full flex items-center justify-center gap-2 font-semibold">
                <i data-lucide="save" class="w-5 h-5"></i> Simpan Data
            </button>
        </form>
        <!-- Tombol Kembali -->
<a href="dashboard.php" class="mt-6 inline-flex items-center justify-center gap-2 bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-700">
    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Dashboard
</a>

    </div>

    <!-- Lucide Icon Script -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
