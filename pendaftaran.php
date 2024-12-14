<?php
// Konfigurasi koneksi database
$host = '127.0.0.1';
$dbname = 'perpustakaan2';
$username = 'root'; // Sesuaikan dengan username database Anda
$password = ''; // Sesuaikan dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// Proses pendaftaran
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Enkripsi password
    $role = 'user'; // Default role
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];

    // Validasi input (Opsional, tambahkan sesuai kebutuhan)
    if (empty($username) || empty($password) || empty($full_name) || empty($email)) {
        echo "Semua field harus diisi!";
        exit;
    }

    // Simpan data ke database
    $query = "INSERT INTO users (username, password, role, full_name, email) VALUES (:username, :password, :role, :full_name, :email)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        echo "Pendaftaran berhasil!";
    } else {
        echo "Terjadi kesalahan saat mendaftar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
</head>
<body>
    <h1>Form Pendaftaran</h1>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" id="full_name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>
