<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM entries WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
header("Location: index.php");
exit();
?>