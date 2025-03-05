<?php
include 'config.php';

$query = "
    SELECT tanggal AS label, SUM(jumlah) AS total 
    FROM jumat_beramal 
    WHERE anonim = 0 
    GROUP BY tanggal 
    ORDER BY tanggal ASC
";

$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'label' => $row['label'],
        'total' => $row['total']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>
