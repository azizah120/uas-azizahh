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

// Proses data jika formulir dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $book_id = $_POST['book_id'];
    $borrow_date = $_POST['borrow_date'];
    $return_date = $_POST['return_date'];

    // Proses upload foto
    $target_dir = "uploads/borrowers/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true); // Buat folder jika belum ada
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;

    // Validasi apakah file yang di-upload adalah gambar
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($imageFileType, $allowed_types)) {
        // Cek apakah file adalah gambar
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check === false) {
            $uploadOk = 0;
            echo "<script>alert('File bukan gambar.');</script>";
        }
    } else {
        $uploadOk = 0;
        echo "<script>alert('Hanya gambar (JPG, JPEG, PNG, GIF) yang diperbolehkan.');</script>";
    }

    // Pindahkan file ke folder tujuan jika valid
    if ($uploadOk && move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $photo = $target_file;
    } else {
        $photo = null;
    }

    // Menyiapkan prepared statement untuk mencegah SQL injection
    $stmt = $conn->prepare("INSERT INTO borrowers (name, book_id, borrow_date, return_date, photo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss", $name, $book_id, $borrow_date, $return_date, $photo);

    if ($stmt->execute()) {
        echo "<script>alert('Data peminjam berhasil ditambahkan!'); window.location.href='borrowers.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Peminjam</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Tambah Data Peminjam</h1>
    <form method="POST" action="add_borrower.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Peminjam</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="book_id" class="form-label">ID Buku</label>
            <input type="number" class="form-control" id="book_id" name="book_id" required>
        </div>
        <div class="mb-3">
            <label for="borrow_date" class="form-label">Tanggal Pinjam</label>
            <input type="date" class="form-control" id="borrow_date" name="borrow_date" required>
        </div>
        <div class="mb-3">
            <label for="return_date" class="form-label">Tanggal Kembali</label>
            <input type="date" class="form-control" id="return_date" name="return_date" required>
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Foto Peminjam</label>
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Data</button>
        <a href="borrowers.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
