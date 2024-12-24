<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $created_at = date("Y-m-d H:i:s");
    $username = $_SESSION['user']; // Ambil username dari session

    $stmt = $conn->prepare("INSERT INTO entries (title, content, created_at, username) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $content, $created_at, $username);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}
include 'header.php';
?>
<h2>Create New Note</h2>
<form method="post">
    <table>
        <tr>
            <td>Title:</td>
            <td><input type="text" name="title" required></td>
        </tr>
        <tr>
            <td>Content:</td>
            <td><textarea name="content" required></textarea></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Add</button></td>
        </tr>
    </table>
</form>
<?php include 'footer.php'; ?>