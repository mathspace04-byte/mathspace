<?php
// Header agar browser tahu ini data JSON (Bukan HTML)
header('Content-Type: application/json');
include 'koneksi.php';

// Ambil data dari tabel rumus
$query = mysqli_query($koneksi, "SELECT * FROM rumus");
$data_rumus = [];

while($row = mysqli_fetch_assoc($query)) {
    $data_rumus[] = $row;
}

// Tampilkan hasil dalam format JSON
$response = [
    "status" => "sukses",
    "pesan" => "Data rumus berhasil diambil dari database MathSpace",
    "data" => $data_rumus
];

echo json_encode($response, JSON_PRETTY_PRINT);
?>