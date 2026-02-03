<?php
session_start();
include 'koneksi.php';

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
    <title>MathSpace - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Import Font */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        /* --- 1. DEFINISI WARNA (VARIABLES) --- */
        :root {
            /* Warna Tema Terang (Default) */
            --bg-gradient: linear-gradient(135deg, #4e54c8, #8f94fb);
            --card-bg: #ffffff;
            --text-color: #333333;
            --text-muted: #666666;
            --border-color: #eeeeee;
            --primary: #4e54c8;
            --secondary: #8f94fb;
            --shadow: rgba(0, 0, 0, 0.2);
            --table-head: #4e54c8;
            --table-hover: #f9f9f9;
        }

        /* Warna Tema Gelap (Dark Mode) */
        body.dark-mode {
            --bg-gradient: linear-gradient(135deg, #0f2027, #203a43, #2c5364); /* Warna Gelap Elegan */
            --card-bg: #1e1e1e;
            --text-color: #e0e0e0;
            --text-muted: #bbbbbb;
            --border-color: #333333;
            --primary: #8f94fb;
            --secondary: #4e54c8;
            --shadow: rgba(0, 0, 0, 0.5);
            --table-head: #333333;
            --table-hover: #2c2c2c;
        }

        /* --- 2. STYLE DASAR --- */
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-gradient);
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-color);
            transition: all 0.5s ease; /* Efek transisi halus */
        }

        .container {
            background: var(--card-bg);
            width: 90%;
            max-width: 900px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px var(--shadow);
            transition: background 0.3s ease;
        }

        h3, h4 { color: var(--primary); margin-bottom: 20px; }

        /* Tombol & Navigasi */
        .btn {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        .btn-danger { background: #ff4b2b; }

        /* Tombol Ganti Tema (Pojok Kanan) */
        .btn-theme {
            background: transparent;
            border: 2px solid var(--text-color);
            color: var(--text-color);
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-theme:hover { background: var(--text-color); color: var(--card-bg); }

        /* Tabs Menu */
        .nav-tabs {
            display: flex;
            gap: 15px;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 15px;
            margin-bottom: 30px;
            justify-content: center;
        }
        .nav-link {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
            transition: 0.3s;
        }
        .nav-link.active, .nav-link:hover {
            background: var(--border-color);
            color: var(--primary);
        }

        /* Tabel Materi */
        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--card-bg);
            border-radius: 10px;
            overflow: hidden;
            margin-top: 10px;
        }
        th { background: var(--table-head); color: white; padding: 15px; text-align: left; }
        td { padding: 15px; border-bottom: 1px solid var(--border-color); color: var(--text-color); }
        tr:hover { background-color: var(--table-hover); }

        .badge {
            background: #e3f2fd; color: #4e54c8;
            padding: 5px 10px; border-radius: 5px; font-size: 0.8rem;
        }
    </style>
</head>
<body>

    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
            <h3 style="margin:0;"><i class="fas fa-shapes"></i> MathSpace</h3>
            
            <div style="display:flex; gap:10px; align-items:center;">
                <button id="theme-toggle" class="btn-theme">
                    <i class="fas fa-moon"></i> Mode Gelap
                </button>
                
                <a href="logout.php" class="btn btn-danger" onclick="return confirm('Keluar dari aplikasi?');" style="padding: 8px 15px;">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>

        <div class="nav-tabs">
            <a href="index.php" class="nav-link active"><i class="fas fa-home"></i> Dashboard</a>
            <a href="upload.php" class="nav-link"><i class="fas fa-cloud-upload-alt"></i> Upload Data</a>
        </div>

        <div>
            <h4 style="color: var(--text-muted);"><i class="fas fa-folder-open"></i> Daftar Materi Tersedia</h4>
            
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Judul Materi</th>
                        <th>Kategori</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM materi ORDER BY id DESC");
                    while($data = mysqli_fetch_array($query)){
                    ?>
                    <tr>
                        <td align="center"><?php echo $no++; ?></td>
                        <td>
                            <b><?php echo $data['judul']; ?></b><br>
                            <small style="color:var(--text-muted);">Diupload: <?php echo $data['tanggal_upload']; ?></small>
                        </td>
                        <td><span class="badge"><?php echo $data['kategori']; ?></span></td>
                        <td>
                            <a href="uploads/<?php echo $data['file_name']; ?>" class="btn" style="font-size:0.8rem;" download>
                                <i class="fas fa-download"></i> DOWNLOAD
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <?php if(mysqli_num_rows($query) == 0): ?>
                <div style="text-align:center; padding: 30px; color: var(--text-muted);">
                    <i class="fas fa-box-open" style="font-size: 3rem; opacity: 0.5;"></i><br>
                    <p>Belum ada materi yang diupload.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('theme-toggle');
        const body = document.body;

        // 1. Cek Memory (LocalStorage) saat pertama buka
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-mode');
            toggleBtn.innerHTML = '<i class="fas fa-sun"></i> Mode Terang';
        }

        // 2. Fungsi saat tombol diklik
        toggleBtn.addEventListener('click', () => {
            body.classList.toggle('dark-mode');

            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                toggleBtn.innerHTML = '<i class="fas fa-sun"></i> Mode Terang';
            } else {
                localStorage.setItem('theme', 'light');
                toggleBtn.innerHTML = '<i class="fas fa-moon"></i> Mode Gelap';
            }
        });
    </script>

</body>
</html>