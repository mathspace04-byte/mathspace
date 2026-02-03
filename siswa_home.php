<?php
session_start();
include 'koneksi.php'; // Koneksi database

// Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - MathSpace</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style_dashboard.css">

    <style>
        /* CSS LOGO NAVBAR */
        .logo-nav {
            height: 45px;
            width: auto;
            object-fit: contain;
            mix-blend-mode: multiply; 
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="siswa_home.php">
                <img src="logo.png" alt="MathSpace" class="logo-nav">
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="siswa_home.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pilihan-kelas">Bahan Ajar</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pilihan-kelas">Kelas</a></li>
                </ul>
                
                <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                    <div class="search-wrapper d-none d-md-block">
                        <i class="fas fa-search search-icon"></i>
                        <form class="search-box"><input type="text" placeholder="Cari materi..."></form>
                    </div>
                    
                    <div class="dropdown">
                        <div class="user-avatar" data-bs-toggle="dropdown" aria-expanded="false">P</div>
                        <ul class="dropdown-menu dropdown-menu-end mt-2 shadow border-0 p-3">
                            <li><h6 class="dropdown-header text-primary fw-bold">Halo, <?= $_SESSION['nama']; ?></h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item rounded" href="#"><i class="fas fa-cog text-muted me-2"></i> Pengaturan</a></li>
                            <li><a class="dropdown-item rounded" href="logout.php"><i class="fas fa-users text-muted me-2"></i> Login Akun Lain</a></li>
                            <li><a class="dropdown-item rounded" href="ganti_password.php"><i class="fas fa-key text-muted me-2"></i> Ganti Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger fw-bold rounded" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        
        <div class="hero-section">
            <div class="hero-content">
                <span class="badge bg-white text-primary fw-bold px-3 py-2 mb-3 shadow-sm rounded-pill">
                    <i class="fas fa-star me-1"></i> E-Learning Terbaik 2026
                </span>
                <h1 class="hero-title">Belajar Matematika Jadi Lebih Seru!</h1>
                <p class="text-muted fs-5 mb-4">Akses materi lengkap, video interaktif, dan latihan soal untuk Kelas 7, 8, dan 9 SMP.</p>
                <a href="#pilihan-kelas" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow">Mulai Belajar</a>
            </div>
            
            <img src="https://img.freepik.com/free-psd/3d-illustration-female-student-reading-book_23-2149436194.png" 
                 class="mascot-img" alt="">
        </div>

        <div id="pilihan-kelas" class="pt-5 pb-4">
            <h4 class="fw-bold mb-4 text-dark"><i class="fas fa-th-large text-primary me-2"></i> Pilih Kelas Kamu</h4>
            <div class="row g-4">
                <div class="col-md-4">
                    <a href="belajar.php?kelas=7&tipe=materi" class="subject-card">
                        <div class="icon-box" style="background:#dbeafe; color:#2563eb;"><i class="fas fa-calculator"></i></div>
                        <div><h5 class="fw-bold m-0">Kelas 7</h5><small class="text-muted fw-bold">Aljabar & Bilangan</small></div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="belajar.php?kelas=8&tipe=materi" class="subject-card">
                        <div class="icon-box" style="background:#dcfce7; color:#16a34a;"><i class="fas fa-shapes"></i></div>
                        <div><h5 class="fw-bold m-0">Kelas 8</h5><small class="text-muted fw-bold">Geometri & Pola</small></div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="belajar.php?kelas=9&tipe=materi" class="subject-card">
                        <div class="icon-box" style="background:#ffedd5; color:#ea580c;"><i class="fas fa-chart-pie"></i></div>
                        <div><h5 class="fw-bold m-0">Kelas 9</h5><small class="text-muted fw-bold">Statistika & Peluang</small></div>
                    </a>
                </div>
            </div>
        </div>

        <div class="pb-5">
            <h4 class="fw-bold mb-3 text-dark"><i class="fas fa-clock text-primary me-2"></i> Update Materi Terbaru</h4>
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Materi</th>
                            <th>Kelas</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM konten ORDER BY id DESC LIMIT 5");
                        
                        while($data = mysqli_fetch_array($query)){
                            $badge_color = "bg-primary";
                            if($data['kelas'] == '8') $badge_color = "bg-success";
                            if($data['kelas'] == '9') $badge_color = "bg-warning text-dark";

                            $tipe_text = "PDF Dokumen";
                            $btn_color = "btn-outline-primary";
                            $btn_text = "Buka";

                            if($data['tipe'] == 'video') {
                                $tipe_text = "Video Pembelajaran";
                                $btn_color = "btn-outline-success";
                                $btn_text = "Tonton";
                            } elseif($data['tipe'] == 'kuis') {
                                $tipe_text = "Latihan Soal";
                                $btn_color = "btn-outline-warning";
                                $btn_text = "Kerjakan";
                            }
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="fw-bold text-dark"><?= $data['judul']; ?></td>
                            <td><span class="badge <?= $badge_color; ?>">Kelas <?= $data['kelas']; ?></span></td>
                            <td><?= $tipe_text; ?></td>
                            <td>
                                <a href="belajar.php?kelas=<?= $data['kelas']; ?>&tipe=<?= $data['tipe']; ?>" 
                                   class="btn btn-sm <?= $btn_color; ?> rounded-pill px-3 fw-bold">
                                   <?= $btn_text; ?>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                        
                        <?php if(mysqli_num_rows($query) == 0): ?>
                        <tr><td colspan="5" class="text-center text-muted py-3">Belum ada materi.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>