<?php
// Sertakan file koneksi database
include 'koneksi.php';

// Periksa apakah form sudah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Validasi input kosong
    if (empty($username) || empty($full_name) || empty($email) || empty($role)) {
        echo "<script>alert('Semua field wajib diisi.'); window.history.back();</script>";
        exit();
    }

    // Query untuk memasukkan data ke tabel users
    $queryInsert = "INSERT INTO users (username, full_name, email, role, created_at) VALUES ('$username', '$full_name', '$email', '$role', NOW())";

    if (mysqli_query($conn, $queryInsert)) {
        echo "<script>alert('Pengguna berhasil didaftarkan.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Gagal mendaftarkan pengguna: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Daftar Pengguna Baru</h1>
        <form action="" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-success">Daftar</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>