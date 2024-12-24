<?php
session_start(); // Pastikan session dimulai
include 'db.php'; // Memanggil database
date_default_timezone_set('Asia/Jakarta'); // Set zona waktu ke WIB
include 'header.php'; // Memanggil header

// Debug: Tampilkan waktu server
echo "Server Time: " . date("d M Y, H:i:s") . "<br>";

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    echo "<h2>Silakan login atau daftar untuk melihat dashboard.</h2>";
    include 'footer.php'; // Menutup footer jika tidak ada konten yang ditampilkan
    exit(); // Hentikan eksekusi script
}

$username = $_SESSION['user']; // Ambil username dari session
?>

<div class="dashboard">
    <h2>Dashboard</h2>
    <div class="stats">
        <h3>Total Catatan: 
            <?php
            $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM entries WHERE username=?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            echo $row['total'];
            $stmt->close();
            ?>
        </h3>
    </div>
    <h3>Catatan Terbaru</h3>
    <table>
        <tr><th>ID</th><th>Title</th><th>Content</th><th>Created At</th><th>Action</th></tr>
        <?php
        $stmt = $conn->prepare("SELECT * FROM entries WHERE username=? ORDER BY created_at DESC LIMIT 5");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars(substr($row['content'], 0, 50)) . '...' ?></td>
                <td>
                    <?php
                    // Ambil waktu dari database dan konversi
                    $created_at = new DateTime($row['created_at'], new DateTimeZone('UTC')); // Misalkan waktu di database adalah UTC
                    $created_at->setTimezone(new DateTimeZone('Asia/Jakarta')); // Ubah ke WIB
                    echo $created_at->format("d M Y, H:i") . " WIB"; // Tampilkan waktu
                    ?>
                </td>
                <td>
                    <a href="update.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>">Delete</a>
                </td>
            </tr>
            <?php endwhile;
        } else {
            echo "Error: " . $conn->error; // Tampilkan pesan error
        }
        ?>
    </table>
</div>

<?php include 'footer.php'; // Menutup footer ?>