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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styling untuk tabel */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table th, table td {
            text-align: center;
            padding: 12px;
        }

        table th {
            background-color: #f8f9fa;
        }

        table td {
            background-color: #fff;
        }

        /* Styling untuk hover di baris tabel */
        tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Styling untuk tombol */
        .btn-custom {
            font-size: 14px;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .container {
            margin-top: 30px;
        }

        .table-wrapper {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        /* Styling untuk tombol action */
        .action-btns .btn {
            margin: 0 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mb-4 text-center">Daftar Pengguna</h1>
    <div class="table-wrapper">
        <table class="table table-striped table-bordered">
            <thead class="thead-light">
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
                foreach ($users as $user) { // Iterasi data pengguna
                    echo "<tr>";
                    echo "<td>{$no}</td>";
                    echo "<td>{$user['username']}</td>";
                    echo "<td>{$user['full_name']}</td>";
                    echo "<td>{$user['email']}</td>";
                    echo "<td>{$user['role']}</td>";
                    echo "<td>{$user['created_at']}</td>";
                    echo "<td class='action-btns'>
                            <a href='register.php' class='btn btn-success btn-sm btn-custom'>
                                <i class='fas fa-user-plus'></i> Daftar
                            </a>
                            <a href='books.php?user_id={$user['user_id']}' class='btn btn-primary btn-sm btn-custom'>
                                <i class='fas fa-book'></i> Book
                            </a>
                          </td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
