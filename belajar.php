<?php
session_start();
include 'koneksi.php';

// Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit();
}

// Ambil Parameter dari URL (Contoh: belajar.php?kelas=7&tipe=materi)
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '7';
$tipe  = isset($_GET['tipe']) ? $_GET['tipe'] : 'materi';

// Label Judul Halaman
$judul_halaman = "Materi Kelas " . $kelas;
if ($tipe == 'video') $judul_halaman = "Video Pembelajaran Kelas " . $kelas;
if ($tipe == 'kuis') $judul_halaman = "Latihan Soal Kelas " . $kelas;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul_halaman; ?> - MathSpace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style_dashboard.css">

    <style>
        .nav-pills .nav-link {
            border-radius: 50px; padding: 8px 25px; font-weight: 700; color: #64748b; background: white; border: 1px solid #e2e8f0; margin: 0 5px;
        }
        .nav-pills .nav-link.active {
            background-color: #3b82f6; color: white; border-color: #3b82f6; box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }
        .content-card {
            background: white; border-radius: 20px; padding: 30px; margin-bottom: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); transition: 0.3s;
        }
        .content-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
        
        /* STYLE KHUSUS VIDEO (IFRAME RESPONSIF) */
        .video-container {
            position: relative; padding-bottom: 56.25%; /* Rasio 16:9 */ height: 0; overflow: hidden; border-radius: 15px; background: #000;
        }
        .video-container iframe {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-light bg-white sticky-top shadow-sm">
        <div class="container py-2">
            <a href="siswa_home.php" class="btn btn-outline-dark rounded-pill fw-bold"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
            <span class="navbar-brand mb-0 h1 fw-bold text-primary ms-3"><?= strtoupper($judul_halaman); ?></span>
            <div class="ms-auto">
                <img src="logo.png" height="40" alt="Logo">
            </div>
        </div>
    </nav>

    <div class="container py-4">

        <div class="d-flex justify-content-center mb-5">
            <div class="nav nav-pills">
                <a href="belajar.php?kelas=<?= $kelas; ?>&tipe=materi" class="nav-link <?= ($tipe == 'materi') ? 'active' : ''; ?>">
                    <i class="fas fa-book-open me-2"></i> Materi PDF
                </a>
                <a href="belajar.php?kelas=<?= $kelas; ?>&tipe=video" class="nav-link <?= ($tipe == 'video') ? 'active' : ''; ?>">
                    <i class="fas fa-play-circle me-2"></i> Video
                </a>
                <a href="belajar.php?kelas=<?= $kelas; ?>&tipe=kuis" class="nav-link <?= ($tipe == 'kuis') ? 'active' : ''; ?>">
                    <i class="fas fa-pencil-alt me-2"></i> Kuis
                </a>
            </div>
        </div>

        <div class="row">
            <?php
            // Query ambil data sesuai Kelas & Tipe
            $query = mysqli_query($koneksi, "SELECT * FROM konten WHERE kelas='$kelas' AND tipe='$tipe'");

            if(mysqli_num_rows($query) > 0) {
                while($data = mysqli_fetch_array($query)) {
            ?>
                <div class="col-md-12">
                    <div class="content-card">
                        <h4 class="fw-bold text-dark mb-1"><?= $data['judul']; ?></h4>
                        <p class="text-muted small mb-3"><?= $data['deskripsi']; ?></p>

                        <?php if($tipe == 'video'): ?>
                            <div class="video-container">
                                <iframe src="<?= $data['file_or_link']; ?>" allowfullscreen></iframe>
                            </div>

                        <?php elseif($tipe == 'materi'): ?>
                            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded border">
                                <i class="fas fa-file-pdf text-danger fa-3x"></i>
                                <div>
                                    <h6 class="fw-bold mb-0">Dokumen Materi</h6>
                                    <small class="text-muted">Format PDF • Siap Unduh</small>
                                </div>
                                <a href="uploads/<?= $data['file_or_link']; ?>" target="_blank" class="btn btn-primary rounded-pill ms-auto px-4 fw-bold">
                                    <i class="fas fa-download me-2"></i> Buka File
                                </a>
                            </div>

                        <?php elseif($tipe == 'kuis'): ?>
                            <div class="alert alert-warning border-0 d-flex align-items-center" role="alert">
                                <i class="fas fa-clipboard-check fa-2x me-3 text-warning"></i>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">Siap Mengerjakan?</h6>
                                    <small class="text-dark">Kerjakan soal ini dengan teliti.</small>
                                </div>
                                <a href="<?= $data['file_or_link']; ?>" target="_blank" class="btn btn-warning text-dark fw-bold rounded-pill ms-auto px-4">
                                    Mulai Kuis <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php 
                } // End While
            } else {
                echo "<div class='col-12 text-center py-5'><h5 class='text-muted'>Belum ada konten untuk kategori ini.</h5></div>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>