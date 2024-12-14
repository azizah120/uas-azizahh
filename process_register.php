<?php
// Koneksi ke database
$host = '127.0.0.1';
$user = 'root'; // Ganti dengan username MySQL Anda
$password = ''; // Ganti dengan password MySQL Anda
$dbname = 'perpustakaan2';

$conn = new mysqli($host, $user, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validasi input
    if (empty($username) || empty($full_name) || empty($email) || empty($password)) {
        die("Semua field wajib diisi.");
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Periksa apakah username atau email sudah digunakan
    $sql_check = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('ss', $username, $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        die("Username atau email sudah terdaftar.");
    }

    // Masukkan data ke database
    $sql = "INSERT INTO users (username, full_name, email, password, role) VALUES (?, ?, ?, ?, 'user')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $username, $full_name, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Pendaftaran berhasil! <a href='login.php'>Login di sini</a>";
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $stmt_check->close();
    $conn->close();
}
?>
