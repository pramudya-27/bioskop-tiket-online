<?php
include 'config/crud.php';

try {
    // Select films that have an old id_jadwal reference
    $films = $proses->tampil("*", "film", "WHERE id_jadwal IS NOT NULL AND id_jadwal != ''");
    
    foreach($films as $f) {
        $id_film = $f['id_film'];
        $id_jadwal = $f['id_jadwal'];
        
        // Update jadwal table to set id_film
        $sql = "UPDATE jadwal SET id_film = '$id_film' WHERE id_jadwal = '$id_jadwal'";
        $proses->con->exec($sql);
        echo "Linked Schedule $id_jadwal to Film $id_film <br>";
    }
    echo "Migration completed.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
