<?php
include 'koneksi.php';
date_default_timezone_set('Asia/Makassar');

// Cek apakah tombol diklik
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $status = $_POST['status'];

    // Simpan ke tabel absensi
    $query = "INSERT INTO absensi (nama_siswa, status) VALUES ('$nama', '$status')";

    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, kembali ke halaman index
        echo "<script>
                alert('Terima kasih, data kehadiran berhasil disimpan!');
                window.location.href='index.php';
              </script>";
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }
}
?>