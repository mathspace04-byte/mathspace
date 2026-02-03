<?php
include 'koneksi.php';

if (isset($_POST['daftar'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'siswa'; // Default role otomatis Siswa

    // 1. Cek apakah username sudah dipakai?
    $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek_user) > 0) {
        $error = "Username sudah terdaftar! Pilih username lain.";
    } 
    // 2. Cek apakah password cocok?
    elseif ($password !== $confirm_password) {
        $error = "Konfirmasi password tidak sesuai!";
    } 
    // 3. Jika aman, simpan ke database
    else {
        // Simpan data
        $insert = mysqli_query($koneksi, "INSERT INTO users (nama_lengkap, username, password, role) VALUES ('$nama', '$username', '$password', '$role')");

        if ($insert) {
            echo "<script>
                    alert('Pendaftaran Berhasil! Silakan Login.');
                    window.location.href='login.php';
                  </script>";
            exit();
        } else {
            $error = "Gagal mendaftar, coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - MathSpace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { 
            background: linear-gradient(135deg, #0ea5e9, #2563eb); 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            font-family: 'Nunito', sans-serif;
            padding: 20px;
        }
        .register-card { 
            background: white;
            border-radius: 20px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.2); 
            padding: 40px;
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        .brand-logo {
            font-size: 2.5rem;
            color: #2563eb;
            margin-bottom: 10px;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            font-weight: 600;
        }
        .form-control:focus {
            background-color: white;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .btn-register {
            background: linear-gradient(90deg, #10b981, #059669); /* Warna Hijau untuk Daftar */
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 50px;
            color: white;
            font-weight: 800;
            font-size: 1rem;
            margin-top: 15px;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="brand-logo">
            <i class="fas fa-user-plus"></i>
        </div>
        <h3 class="fw-bolder text-dark mb-1">Buat Akun Baru</h3>
        <p class="text-muted mb-4 small fw-bold">Gabung MathSpace sekarang!</p>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger py-2 mb-3 text-start small fw-bold">
                <i class="fas fa-exclamation-triangle me-1"></i> <?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3 text-start">
                <label class="form-label small text-secondary fw-bold ms-1">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso" required>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label small text-secondary fw-bold ms-1">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Buat username unik" required>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3 text-start">
                    <label class="form-label small text-secondary fw-bold ms-1">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="****" required>
                </div>
                <div class="col-md-6 mb-3 text-start">
                    <label class="form-label small text-secondary fw-bold ms-1">Ulangi Password</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="****" required>
                </div>
            </div>
            
            <button type="submit" name="daftar" class="btn btn-register">DAFTAR SEKARANG</button>
        </form>
        
        <div class="mt-4 text-muted small fw-bold">
            Sudah punya akun? <a href="login.php" class="text-primary text-decoration-none">Login disini</a>
        </div>
    </div>

</body>
</html>