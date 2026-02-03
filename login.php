<?php
session_start();
include 'koneksi.php';

// --- 1. CEK COOKIES ---
if (isset($_COOKIE['id_user']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id_user'];
    $key = $_COOKIE['key'];
    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'");
    $row = mysqli_fetch_assoc($result);
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['status'] = "login";
        $_SESSION['role'] = $row['role'];
        $_SESSION['nama'] = $row['nama_lengkap'];
    }
}

// --- 2. PENGALIHAN ---
if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
    if ($_SESSION['role'] == "admin") header("location:admin_dashboard.php");
    else header("location:siswa_home.php");
    exit();
}

// --- 3. PROSES LOGIN ---
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $q = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($q) > 0) {
        $data = mysqli_fetch_assoc($q);
        $_SESSION['status'] = "login";
        $_SESSION['role'] = $data['role'];
        $_SESSION['nama'] = $data['nama_lengkap'];
        $_SESSION['id_user'] = $data['id'];

        if (isset($_POST['ingat_saya'])) {
            setcookie('id_user', $data['id'], time() + (60 * 60 * 24 * 7), '/');
            setcookie('key', hash('sha256', $data['username']), time() + (60 * 60 * 24 * 7), '/');
        }

        if ($data['role'] == "admin") header("location:admin_dashboard.php");
        else header("location:siswa_home.php");
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - MathSpace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { 
            background: linear-gradient(135deg, #0ea5e9, #2563eb); 
            height: 100vh; 
            display: flex; align-items: center; justify-content: center;
            font-family: 'Nunito', sans-serif;
        }
        .login-card { 
            background: white;
            border-radius: 20px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.2); 
            padding: 40px;
            width: 100%; max-width: 400px;
            text-align: center;
        }
        
        /* STYLE LOGO (Agar Bersih) */
        .login-logo-img {
            width: 150px; /* Ukuran Pas */
            height: auto;
            margin-bottom: 10px;
            object-fit: contain;
            
            /* Trik CSS: Jika kamu belum sempat hapus background di remove.bg, 
               kode ini akan mencoba menyamarkan warna putihnya */
            mix-blend-mode: multiply; 
        }

        .form-control {
            border-radius: 12px; padding: 12px 15px;
            background-color: #f8fafc; border: 1px solid #e2e8f0; font-weight: 600;
        }
        .form-control:focus {
            background-color: white; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .btn-login {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            border: none; width: 100%; padding: 12px;
            border-radius: 50px; color: white; font-weight: 800;
            margin-top: 15px; transition: 0.3s;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4); }
        .forgot-link { color: #ef4444; text-decoration: none; font-weight: 700; font-size: 0.85rem; }
        .forgot-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="login-card">
        
        <div class="mb-2">
            <img src="logo.png" alt="MathSpace" class="login-logo-img">
        </div>

        <p class="text-muted mb-4 small fw-bold">Portal Belajar Matematika Terpadu</p>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger py-2 mb-3 text-start shadow-sm border-0" style="background-color: #fef2f2; border-left: 4px solid #ef4444 !important;">
                <div class="d-flex align-items-center gap-2 text-danger fw-bold small">
                    <i class="fas fa-exclamation-circle"></i> Login Gagal!
                </div>
                <div class="text-muted small mt-1">Username atau Password salah.</div>
                <div class="mt-2 pt-2 border-top border-danger-subtle">
                    <a href="ganti_password.php" class="forgot-link">Lupa kata sandi?</a>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3 text-start">
                <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
            </div>
            
            <div class="mb-3 text-start">
                <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="ingat_saya" id="remember" style="cursor: pointer;">
                    <label class="form-check-label text-muted small fw-bold" for="remember" style="cursor: pointer;">Ingat Saya</label>
                </div>
            </div>
            
            <button type="submit" name="login" class="btn btn-login">MASUK SEKARANG</button>
        </form>
        
        <div class="mt-4 text-muted small fw-bold">
            Belum punya akun? <a href="daftar.php" class="text-primary text-decoration-none">Daftar</a>
        </div>
    </div>

</body>
</html>