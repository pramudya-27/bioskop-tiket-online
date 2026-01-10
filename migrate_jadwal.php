<?php
include 'config/crud.php';

try {
    // Select all films that have a schedule assigned
    $films = $proses->tampil("*", "film", "WHERE id_jadwal != ''");
    
    foreach ($films as $f) {
        $id_film = $f['id_film'];
        $id_jadwal = $f['id_jadwal'];
        
        $sql = "UPDATE jadwal SET id_film = '$id_film' WHERE id_jadwal = '$id_jadwal'";
        $proses->con->exec($sql);
        echo "Updated Jadwal $id_jadwal with Film $id_film <br>";
    }
    echo "Migration Complete.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
