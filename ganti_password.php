<?php
session_start();
include 'koneksi.php';

// Kalau belum login, tidak boleh masuk sini
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit();
}

// LOGIKA GANTI PASSWORD
if (isset($_POST['simpan'])) {
    $id_user = $_SESSION['id_user'];
    $pass_lama = $_POST['pass_lama'];
    $pass_baru = $_POST['pass_baru'];
    $pass_konfirmasi = $_POST['pass_konfirmasi'];

    // 1. Cek Password Lama
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id_user' AND password='$pass_lama'");
    
    if (mysqli_num_rows($cek) == 0) {
        $error = "Password lama salah!";
    } 
    // 2. Cek Password Baru & Konfirmasi
    elseif ($pass_baru !== $pass_konfirmasi) {
        $error = "Konfirmasi password tidak cocok!";
    } 
    else {
        // 3. Update Database
        $update = mysqli_query($koneksi, "UPDATE users SET password='$pass_baru' WHERE id='$id_user'");
        if ($update) {
            echo "<script>alert('Password berhasil diganti! Silakan login ulang.'); window.location.href='logout.php';</script>";
        } else {
            $error = "Gagal mengganti password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - MathSpace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #0ea5e9, #2563eb); font-family: 'Nunito', sans-serif; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card-custom { background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); width: 100%; max-width: 400px; padding: 30px; }
        .form-control { border-radius: 10px; padding: 10px; background: #f8fafc; }
        .btn-save { background: #0ea5e9; color: white; border-radius: 50px; width: 100%; padding: 10px; font-weight: 800; border: none; }
        .btn-save:hover { background: #0284c7; }
        .back-link { text-decoration: none; color: #64748b; font-weight: 700; display: block; text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="card-custom">
        <h4 class="fw-bold text-center mb-4 text-dark">Ganti Kata Sandi</h4>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger py-2 small fw-bold text-center"><?= $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="small text-muted fw-bold mb-1">Password Lama</label>
                <input type="password" name="pass_lama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="small text-muted fw-bold mb-1">Password Baru</label>
                <input type="password" name="pass_baru" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="small text-muted fw-bold mb-1">Ulangi Password Baru</label>
                <input type="password" name="pass_konfirmasi" class="form-control" required>
            </div>
            <button type="submit" name="simpan" class="btn-save">SIMPAN PASSWORD</button>
            <a href="siswa_home.php" class="back-link">Batal & Kembali</a>
        </form>
    </div>
</body>
</html>