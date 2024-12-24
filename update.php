<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM entries WHERE id=$id");
if ($result->num_rows == 0) {
    die("Note not found.");
}
$entry = $result->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $conn->prepare("UPDATE entries SET title=?, content=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}
include 'header.php';
?>
<h2>Edit Note</h2>
<form method="post">
    <table>
        <tr>
            <td>Title:</td>
            <td><input type="text" name="title" value="<?= htmlspecialchars($entry['title']) ?>" required></td>
        </tr>
        <tr>
            <td>Content:</td>
            <td><textarea name="content" required><?= htmlspecialchars($entry['content']) ?></textarea></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Update</button></td>
        </tr>
    </table>
</form>
<?php include 'footer.php'; ?>