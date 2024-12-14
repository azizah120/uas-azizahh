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
$sql_users = "SELECT * FROM users";
$result_users = $conn->query($sql_users);

// Ambil data dari tabel books
$sql_books = "SELECT * FROM books";
$result_books = $conn->query($sql_books);

// Simpan data ke dalam array $users dan $books
$users = [];
if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $users[] = $row;
    }
}

$books = [];
if ($result_books->num_rows > 0) {
    while ($row = $result_books->fetch_assoc()) {
        $books[] = $row;
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
    <title>Admin Dashboard - Daftar Pengguna dan Buku</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f8fb;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 1100px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 30px;
            color: #007bff;
        }

        h2 {
            font-size: 22px;
            margin-bottom: 20px;
            color: #333;
        }

        .table {
            margin-bottom: 30px;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table-bordered {
            border: 1px solid #e1e1e1;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            transform: translateY(-2px);
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 18px;
            text-align: center;
        }

        .card-body {
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Dashboard Admin</h1>

        <!-- Daftar Pengguna -->
        <div class="card">
            <div class="card-header">
                <h2>Daftar Pengguna</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Dibuat</th>
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
                            echo "</tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Daftar Buku -->
        <div class="card">
            <div class="card-header">
                <h2>Daftar Buku</h2>
            </div>
            <div class="card-body">
                <a href="tambah_buku.php" class="btn btn-primary mb-3">Tambah Buku</a>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($books as $book) {
                            echo "<tr>";
                            echo "<td>{$no}</td>";
                            echo "<td>{$book['title']}</td>";
                            echo "<td>{$book['author']}</td>";
                            echo "<td>{$book['publisher']}</td>";
                            echo "<td>{$book['year']}</td>";
                            echo "</tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
