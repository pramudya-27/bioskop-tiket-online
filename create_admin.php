<?php
include 'config/crud.php';

$user = "admin";
$pass = md5("admin123"); // Default password
$level = "admin";

try {
    // Check if user exists
    $check = $proses->con->prepare("SELECT * FROM admin WHERE nama = ?");
    $check->execute([$user]);
    
    if ($check->rowCount() > 0) {
        // Update existing admin password
        $update = $proses->con->prepare("UPDATE admin SET password = ? WHERE nama = ?");
        $update->execute([$pass, $user]);
        echo "User 'admin' sudah ada. <br>";
        echo "Password berhasil di-reset menjadi: <b>admin123</b>";
    } else {
        // Insert new admin
        $sql = "INSERT INTO admin (id_admin, nama, password, level) VALUES (NULL, ?, ?, ?)";
        $stmt = $proses->con->prepare($sql);
        $stmt->execute([$user, $pass, $level]);
        echo "Berhasil membuat akun admin! <br>";
        echo "Username: <b>admin</b> <br>";
        echo "Password: <b>admin123</b>";
    }
} catch (PDOException $e) {
    echo "Gagal: " . $e->getMessage();
}
?>
