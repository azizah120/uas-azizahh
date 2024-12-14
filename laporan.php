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

// Ambil data dari tabel borrowers
$sql = "SELECT * FROM borrowers";
$result = $conn->query($sql);

// Simpan data ke dalam array $borrowers
$borrowers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $borrowers[] = $row;
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
    <title>Laporan Daftar Peminjam</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Tombol Cetak disembunyikan saat cetak */
        .no-print {
            display: inline-block;
        }

        @media print {
            .no-print {
                display: none;
            }

            body * {
                visibility: hidden;
            }

            .print-area, .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Laporan Daftar Peminjam</h1>
    
    <div class="print-area">
        <!-- Tabel Daftar Peminjam -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>ID Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Foto Peminjam</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($borrowers as $borrower) {
                    echo "<tr>";
                    echo "<td>{$no}</td>";
                    echo "<td>{$borrower['name']}</td>";
                    echo "<td>{$borrower['book_id']}</td>";
                    echo "<td>{$borrower['borrow_date']}</td>";
                    echo "<td>{$borrower['return_date']}</td>";
                    echo "<td>";
                    if ($borrower['photo']) {
                        echo "<img src='{$borrower['photo']}' alt='Foto Peminjam' style='width: 100px; height: auto;'>";
                    } else {
                        echo "Tidak ada foto";
                    }
                    echo "</td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Tombol untuk mencetak laporan -->
    <button class="btn btn-primary no-print" onclick="window.print()">Cetak Laporan</button>
    <a href="borrowers.php" class="btn btn-secondary no-print">Kembali</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
