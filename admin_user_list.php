<?php
// Hardcode role admin, tanpa login
$role = 'admin';  // Ganti dengan role admin jika Anda ingin menetapkan role secara manual

// Cek apakah yang mengakses adalah admin
if ($role !== 'admin') {
    echo "Akses ditolak. Anda bukan admin.";
    exit;  // Hentikan eksekusi jika bukan admin
}

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

// Ambil data dari tabel users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Simpan data ke dalam array $users
$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    
    <h1>Daftar Pengguna</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Role</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>{$no}</td>";
                echo "<td>{$user['username']}</td>";
                echo "<td>{$user['full_name']}</td>";
                echo "<td>{$user['email']}</td>";
                echo "<td>{$user['role']}</td>";
                echo "<td>{$user['created_at']}</td>";
                echo "<td>
                    <a href='edit_user.php?id={$user['user_id']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='delete_user.php?id={$user['user_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pengguna ini?\")'>Hapus</a>
                </td>";
                echo "</tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
