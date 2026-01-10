<?php
include 'config/crud.php';

try {
    $sql = "ALTER TABLE film ADD COLUMN id_tiket VARCHAR(50)";
    $proses->con->exec($sql);
    echo "Column id_tiket added successfully to film table.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
