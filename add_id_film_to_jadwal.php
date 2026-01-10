<?php
include 'config/crud.php';

try {
    // Check if column exists first or just try to add it. 
    // Since SQL error confirms it's missing (or implies it), we just add.
    // Adding after id_jadwal for better visibility.
    $sql = "ALTER TABLE jadwal ADD COLUMN id_film INT AFTER id_jadwal";
    $proses->con->exec($sql);
    echo "Column id_film added successfully to jadwal table.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
