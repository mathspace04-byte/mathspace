<?php
session_start();
include 'koneksi.php';

if (isset($_POST['upload'])) {
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];
    
    // Logic Upload File
    $filename = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $folder = "uploads/" . $filename;

    if (move_uploaded_file($tmp_name, $folder)) {
        // Simpan ke Database
        mysqli_query($koneksi, "INSERT INTO materi (judul, kategori, file_name) VALUES ('$judul', '$kategori', '$filename')");
        echo "<script>alert('Berhasil Upload!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal Upload File!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Data - MathSpace</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h2>📤 Upload Data Baru</h2>
        
        <div class="nav-tabs">
            <a href="index.php">🏠 Dashboard</a>
            <a href="upload.php" class="active">📤 Upload Page</a>
        </div>

        <form action="" method="POST" enctype="multipart/form-data" style="max-width: 500px;">
            <label>Judul Materi/Rumus:</label>
            <input type="text" name="judul" placeholder="Contoh: Rumus Aljabar" required>

            <label>Kategori:</label>
            <select name="kategori">
                <option value="Rumus">Bank Rumus</option>
                <option value="Materi">Materi Pelajaran</option>
            </select>

            <label>Pilih File (PDF/Word):</label>
            <input type="file" name="file" required>

            <br><br>
            <button type="submit" name="upload" class="btn">Simpan & Upload</button>
        </form>
    </div>

</body>
</html>