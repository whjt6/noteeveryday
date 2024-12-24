<?php
session_start(); // Pastikan session dimulai
include 'db.php'; // Pastikan file koneksi database sudah ada
include 'header.php'; // Sertakan header dengan CSS

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email']; // Ambil email dari form
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Cek apakah username sudah ada
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Username sudah terdaftar.";
        exit(); // Hentikan eksekusi jika username sudah ada
    }
    $stmt->close();

    // Cek apakah email sudah ada
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Email sudah terdaftar.";
        exit(); // Hentikan eksekusi jika email sudah ada
    }
    $stmt->close();

    // Jika username dan email belum terdaftar, simpan ke database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password); // Binding parameter

    // Eksekusi statement dan cek keberhasilan
    if ($stmt->execute()) {
        echo "Registrasi berhasil! Silakan login.";
        header("Location: login.php"); // Redirect ke halaman login
        exit();
    } else {
        echo "Error: " . $stmt->error; // Menampilkan error jika terjadi
    }
    $stmt->close();
}
?>

<!-- Form Registrasi -->
<h2>Register</h2>
<form method="post">
    <table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="username" required></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="email" name="email" required></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" required></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Register</button></td>
        </tr>
    </table>
</form>

<?php include 'footer.php'; // Sertakan footer ?>