<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "note_everyday";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    date_default_timezone_set('Asia/Jakarta');
}
?>