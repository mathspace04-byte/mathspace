<?php
session_start();
include 'koneksi.php';
if($_SESSION['role'] != 'admin') header("location:login.php");

// LOGIK UPLOAD
if(isset($_POST['upload'])){
    $judul = $_POST['judul'];
    $desc  = $_POST['deskripsi'];
    $kelas = $_POST['kelas'];
    $tipe  = $_POST['tipe'];
    
    if($tipe == 'materi'){
        $file = $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], "uploads/".$file);
        $link = $file;
    } else {
        $link = $_POST['link_url'];
    }

    mysqli_query($koneksi, "INSERT INTO konten (judul, deskripsi, kelas, tipe, file_or_link) VALUES ('$judul', '$desc', '$kelas', '$tipe', '$link')");
    echo "<script>alert('Berhasil Upload!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Admin Panel MathSpace</span>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="alert alert-info">
            Halo, <b><?= $_SESSION['nama']; ?></b>. Anda memiliki akses penuh untuk mengelola dan melihat konten.
        </div>

        <div class="row">
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">📤 Upload Materi Baru</div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-2">
                                <label>Judul:</label>
                                <input type="text" name="judul" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Deskripsi:</label>
                                <textarea name="deskripsi" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label>Kelas:</label>
                                    <select name="kelas" class="form-select">
                                        <option value="7">Kelas 7</option>
                                        <option value="8">Kelas 8</option>
                                        <option value="9">Kelas 9</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label>Tipe:</label>
                                    <select name="tipe" id="tipeSelect" class="form-select" onchange="cekTipe()">
                                        <option value="materi">PDF</option>
                                        <option value="video">Video</option>
                                        <option value="kuis">Kuis</option>
                                    </select>
                                </div>
                            </div>
                            <div id="inputPDF" class="mb-3">
                                <label>File PDF:</label>
                                <input type="file" name="file" class="form-control">
                            </div>
                            <div id="inputLink" class="mb-3" style="display:none;">
                                <label>Link URL:</label>
                                <input type="text" name="link_url" class="form-control" placeholder="https://...">
                            </div>
                            <button type="submit" name="upload" class="btn btn-success w-100">UPLOAD</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">👁️ Pantau Ruang Belajar (View All)</div>
                    <div class="card-body">
                        <p>Klik tombol di bawah untuk melihat tampilan materi seperti yang dilihat siswa, sekaligus menghapus materi jika perlu.</p>
                        <div class="d-grid gap-2">
                            <a href="belajar.php?kelas=7&tipe=materi" class="btn btn-outline-primary p-3 text-start">
                                🎒 <b>Buka Materi Kelas 7</b> <small class="text-muted d-block">Lihat Aljabar, Bilangan...</small>
                            </a>
                            <a href="belajar.php?kelas=8&tipe=materi" class="