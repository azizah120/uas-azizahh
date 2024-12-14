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

// Periksa apakah ID pengguna ada di parameter URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Query untuk menghapus data pengguna berdasarkan user_id
    $sql = "DELETE FROM users WHERE user_id = ?";
    
    // Persiapkan statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id); // Mengikat parameter ID sebagai integer
        if ($stmt->execute()) {
            // Redirect ke halaman daftar pengguna setelah berhasil dihapus
            header("Location: index.php?status=success");
        } else {
            echo "Terjadi kesalahan saat menghapus data: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Gagal menyiapkan query: " . $conn->error;
    }
} else {
    echo "ID pengguna tidak ditemukan.";
}

// Tutup koneksi
$conn->close();
?>