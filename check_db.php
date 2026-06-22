<?php
$conn = new mysqli('localhost', 'root', '', 'laptopku_db');
if($conn->connect_error) {
    echo 'Koneksi gagal: ' . $conn->connect_error;
} else {
    $result = $conn->query('SELECT COUNT(*) as total FROM products');
    $row = $result->fetch_assoc();
    echo 'Total produk: ' . $row['total'];
}
?>
