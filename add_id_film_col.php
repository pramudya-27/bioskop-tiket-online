<?php
include 'config/crud.php';

try {
    $sql = "ALTER TABLE jadwal ADD COLUMN id_film INT(11) NOT NULL AFTER id_jadwal";
    $proses->con->exec($sql);
    echo "Column id_film added successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
