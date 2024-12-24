<?php
session_start(); // Pastikan session dimulai
include 'db.php'; // Memanggil database

if (isset($_SESSION['user'])) {
    header("Location: create.php"); // Arahkan ke halaman Add Note jika sudah login
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username; // Simpan username di session
            header("Location: create.php"); // Arahkan ke halaman Add Note
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
    $stmt->close();
}
include 'header.php';
?>
<h2>Login</h2>
<form method="post">
    <table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="username" required></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" required></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Login</button></td>
        </tr>
    </table>
    <?php if (isset($error)): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>
</form>
<?php include 'footer.php'; ?>