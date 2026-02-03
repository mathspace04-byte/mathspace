<?php
session_start();

// 1. HAPUS SEMUA SESSION
$_SESSION = [];
session_unset();
session_destroy();

// 2. HAPUS COOKIES (DENGAN BERBAGAI CARA)
// Hapus cookie versi root (yang baru)
setcookie('id_user', '', time() - 3600, '/');
setcookie('key', '', time() - 3600, '/');

// Hapus cookie versi lokal (yang lama/nyangkut)
setcookie('id_user', '', time() - 3600);
setcookie('key', '', time() - 3600);

// 3. PAKSA PINDAH KE LOGIN
echo "<script>
        alert('Logout Berhasil!');
        window.location.replace('login.php');
      </script>";
exit();
?>