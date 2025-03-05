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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <td>
                    <button class="btn btn-danger btn-sm" onclick="hapusKelas(${index})">Hapus</button>
                </td>
            `;
        });

        // Perbarui opsi kelas di datalist
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
<body>
    <div class="container mt-4">
        <h3>Tambah Data - <?php echo $tanggal; ?></h3>
        <form action="" method="POST" class="mb-3">
            <div class="row">
                <div class="col-md-5">
                    <input type="text" id="kelasInput" name="kelas" class="form-control" list="kelasList" placeholder="Ketik Nama Kelas" required>
                    <datalist id="kelasList">
                 <?php foreach ($kelas_list as $kelas) { ?>
                     <option value="<?php echo htmlspecialchars($kelas); ?>"></option>
                <?php } ?>
                </datalist>
                </div>
                <div class="col-md-4">
                    <input type="number" id="jumlahInput" name="jumlah" class="form-control" placeholder="Jumlah Sumbangan" required>
                </div>
                <div class="col-md-3">
                    <input type="checkbox" id="anonimInput"> Anonim
                </div>
                <div class="col-md-3">
                    <button id="tambahKelas" class="btn btn-success">Tambahkan</button>
                </div>
            </div>
        </form>
        
        <h4 class="mt-4">Data Kelas yang Ditambahkan:</h4>
        <div class="scrollable-table">
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Jumlah Sumbangan</th>
                        <th>Anonim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="kelasTable">
                    <?php while ($row = mysqli_fetch_assoc($data)) { ?>
                    <tr>
                        <td><?php echo $row['kelas']; ?></td>
                        <td>Rp<?php echo number_format($row['jumlah'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['anonim'] ? 'Ya' : 'Tidak'; ?></td>
                        <td><button class="btn btn-danger btn-sm">Hapus</button></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <form id="dataForm" action="" method="POST">
            <input type="hidden" name="data_json" id="data_json">
            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>
</html>
